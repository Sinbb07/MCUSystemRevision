<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amendments;
use App\Models\Approved;
use App\Models\FormUser;
use App\Models\FormsTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AmendmentsERB extends Controller
{
    public function assignedAmendments()
    {
        $approvedProtocols = Approved::with([
            'user', 
            'protocol.researchInformation'
        ])
        ->where('Decision', 'Approved')
        ->get();

        return view('erb.resubmission', compact('approvedProtocols'));
    }

    public function assignAmendments(Request $request)
    {
        try {
            Log::info('Raw request data:', $request->all());

            // Remove integer validation since your IDs are strings
            $validator = Validator::make($request->all(), [
                'protocols' => 'required|array|min:1',
                'protocols.*.user_id' => 'required|string',
                'protocols.*.protocol_id' => 'required|string',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed:', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            $selectedProtocols = $request->input('protocols', []);

            Log::info('Processing protocols:', ['count' => count($selectedProtocols), 'protocols' => $selectedProtocols]);

            DB::transaction(function () use ($selectedProtocols) {
                // Get form IDs
                $formCodes = ['FORM 3(D)', 'FORM 3(E)', 'Upload FORM 3(D) Soft Copy', 'Upload Form 3(E) Soft Copy','MCUERB VERSION 2 DOCUMENTS'];
                $forms = FormsTable::whereIn('form_code', $formCodes)
                    ->pluck('form_id', 'form_code')
                    ->toArray();

                Log::info('Found forms:', $forms);

                if (empty($forms)) {
                    throw new \Exception('No amendment forms found in the system.');
                }

                $userIds = array_column($selectedProtocols, 'user_id');
                $protocolIds = array_column($selectedProtocols, 'protocol_id');
                
                // Get existing amendments
                $existingAmendments = Amendments::whereIn('user_ID', $userIds)
                    ->whereIn('Protocol_ID', $protocolIds)
                    ->get()
                    ->keyBy(function ($item) {
                        return $item->user_ID . '_' . $item->Protocol_ID;
                    });

                Log::info('Existing amendments:', ['count' => $existingAmendments->count()]);

                // Get existing form assignments
                $existingForms = FormUser::whereIn('user_ID', $userIds)
                    ->whereIn('form_id', array_values($forms))
                    ->get()
                    ->groupBy('user_ID')
                    ->map(function ($userForms) {
                        return $userForms->pluck('form_id')->toArray();
                    })
                    ->toArray();

                Log::info('Existing forms per user:', $existingForms);

                $amendmentsToCreate = [];
                $formsToAssign = [];

                foreach ($selectedProtocols as $protocol) {
                    $userId = $protocol['user_id'];
                    $protocolId = $protocol['protocol_id'];
                    $key = $userId . '_' . $protocolId;
                    
                    // Check if amendment doesn't exist
                    if (!$existingAmendments->has($key)) {
                        $amendmentsToCreate[] = [
                            'user_ID' => $userId,
                            'Protocol_ID' => $protocolId,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }

                    // Check and prepare form assignments
                    $userExistingForms = $existingForms[$userId] ?? [];
                    
                    foreach ($forms as $formId) {
                        if (!in_array($formId, $userExistingForms)) {
                            $formsToAssign[] = [
                                'user_ID' => $userId,
                                'form_id' => $formId,
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                        }
                    }
                }

                Log::info('Database operations:', [
                    'amendments_to_create' => count($amendmentsToCreate),
                    'forms_to_assign' => count($formsToAssign)
                ]);

                // Bulk insert amendments
                if (!empty($amendmentsToCreate)) {
                    Amendments::insert($amendmentsToCreate);
                    Log::info('Amendments inserted successfully');
                }

                // Bulk insert forms
                if (!empty($formsToAssign)) {
                    FormUser::insert($formsToAssign);
                    Log::info('Forms inserted successfully');
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Amendments assigned successfully! Forms have been assigned to the selected users.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error assigning amendments: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error assigning amendments: ' . $e->getMessage()
            ], 500);
        }
    }
}