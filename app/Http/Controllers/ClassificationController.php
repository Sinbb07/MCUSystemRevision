<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classification;
use App\Mail\UserCredentialMail;
use App\Models\User;
use App\Notifications\UserClassified;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\ProcessMonitoring;

class ClassificationController extends Controller
{
    // Display all classifications
    public function index() {
        // Keep variable as $pi, but fetch classifications with user info
        $pi = User::with(['researchInformation','classifications'])
        ->where('user_Access', 'Principal Investigator')
        ->whereDoesntHave('classifications', function($query) {
            $query->where('classificationStatus', 'Approved');
        })   
        ->get();
        return view('superadmin.accounts-classifications', compact('pi'));
    }

    public function bulkUpdate(Request $request) {
        $request->validate([
            'user_ids' => 'required|array',
            'reviewClassification' => 'required|string|max:255',
        ]);

        $userIds = $request->user_ids;
        $classificationType = $request->reviewClassification;

        // Get ERB admins to notify
        $erbAdmins = User::where('user_Access', 'ERB Admin')->get();

        DB::beginTransaction();

        try {
            foreach ($userIds as $id) {
                // Find or create classification for each user
                $classification = Classification::firstOrCreate(
                    ['user_ID' => $id],
                    ['classificationStatus' => 'Pending']
                );

                // Update classification
                $classification->update([
                    'reviewClassification' => $classificationType,
                    'classificationStatus' => 'Approved',
                    'classificationDate' => now()
                ]);

                // Send email to user
                $user = User::find($id);
                if ($user) {
                    Mail::to($user->user_Email)->queue(new UserCredentialMail($user, $classificationType));
                    
                    // ✅ PROCESS MONITORING: Super Admin Classification (OUTGOING)
                    ProcessMonitoring::create([
                        'process_code' => 'SA2',
                        'process_description' => 'Classification: ' . $classificationType . ' for ' . $user->user_Fname . ' ' . $user->user_Lname,
                        'user_type' => 'super_admin',
                        'direction' => 'out',
                        'timestamp' => now(),
                        'action_by_user_id' => auth()->user()->user_ID, // Super Admin performing classification
                        'action_by_user_type' => 'super_admin',
                        'affected_user_id' => $user->user_ID,
                        'affected_user_type' => 'pi',
                    ]);

                    // ✅ PROCESS MONITORING: PI Receives Approval (INCOMING)
                    ProcessMonitoring::create([
                        'process_code' => 'PI1',
                        'process_description' => 'Approval IRO: ' . $classificationType,
                        'user_type' => 'pi',
                        'direction' => 'in',
                        'timestamp' => now(),
                        'action_by_user_id' => auth()->user()->user_ID,
                        'action_by_user_type' => 'super_admin',
                        'affected_user_id' => $user->user_ID,
                        'affected_user_type' => 'pi',
                    ]);

                    // Determine which admin type based on classification
                    $adminType = ($classificationType === 'ERB') ? 'admin_erb' : 'admin_iacuc';
                    $processCode = ($classificationType === 'ERB') ? 'ERB1' : 'IAC1';

                    // ✅ PROCESS MONITORING: ERB/IACUC Admin Receives Classification (INCOMING)
                    ProcessMonitoring::create([
                        'process_code' => $processCode,
                        'process_description' => 'Received classified (' . $classificationType . ') for ' . $user->user_Fname . ' ' . $user->user_Lname,
                        'user_type' => $adminType,
                        'direction' => 'in',
                        'timestamp' => now(),
                        'action_by_user_id' => auth()->user()->user_ID,
                        'action_by_user_type' => 'super_admin',
                        'affected_user_id' => null, // All admins of this type will see it
                        'affected_user_type' => $adminType,
                    ]);

                    // Send notification to all ERB/IACUC admins
                    foreach ($erbAdmins as $admin) {
                        $admin->notify(new UserClassified($user, $classificationType));
                        
                        // ✅ PROCESS MONITORING: Individual Admin Notification
                        ProcessMonitoring::create([
                            'process_code' => $processCode,
                            'process_description' => 'Notification: Received ' . $classificationType . ' classification for ' . $user->user_Fname . ' ' . $user->user_Lname,
                            'user_type' => $adminType,
                            'direction' => 'in',
                            'timestamp' => now(),
                            'action_by_user_id' => auth()->user()->user_ID,
                            'action_by_user_type' => 'super_admin',
                            'affected_user_id' => $admin->user_ID,
                            'affected_user_type' => $adminType,
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Selected users have been classified and credentials sent!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // ✅ PROCESS MONITORING: Classification Failed
            ProcessMonitoring::create([
                'process_code' => 'SA2',
                'process_description' => 'Classification failed: ' . $e->getMessage(),
                'user_type' => 'super_admin',
                'direction' => 'out',
                'timestamp' => now(),
                'action_by_user_id' => auth()->user()->user_ID,
                'action_by_user_type' => 'super_admin',
                'affected_user_id' => null,
                'affected_user_type' => null,
                'metadata' => ['error' => $e->getMessage(), 'user_ids' => $userIds]
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Classification failed: ' . $e->getMessage()
            ], 500);
        }
    }
}