<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ResearchInformation;
use App\Notifications\NewRegisteredUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Mail\NewUserCredential;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\ProcessMonitoring;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    //Display the registration view.
    public function create(): View
    {
        return view('auth.register');
    }
    public function index(Request $request){
            $users = User::all();

        if ($request->wantsJson()) {
        return response()->json([
            'status' => 'success',
            'count' => $users->count(),
            'data' => $users
        ]);
        }

        return view('superadmin.permission-control', compact(('users')));
    }
    /**
     * Handle an incoming registration request.
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'user_Fname' => ['required', 'string', 'max:255'],
            'user_Lname' => ['required', 'string', 'max:255'],
            'user_MI' => ['nullable', 'alpha', 'max:2'],
            'user_Password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'user_Email' => 'required|email|unique:tbl_users,user_Email',
            'user_Access' => ['nullable'],

            'research_CoInvestigator' => ['nullable', 'string', 'max:255'],
            'research_title' => ['required', 'string', 'max:255'],
            'research_type' => ['required', 'string', Rule::in([
                'MCU Undergraduate Student',
                'MCU Graduate Student',
                'MCU Faculty',
                'MCU Non-Teaching Staff',
                'MCU Administrative Staff',
                'Non-MCU Researcher',
            ])],
            'research_Contact' => ['required', 'string', 'max:20'],

            // ✅ School required only if checkmcu IS present
            'research_college' => [Rule::requiredIf(!$request->has('research_checkmcu')), 'nullable', 'string', 'max:255'],
            'research_department' => [Rule::requiredIf(!$request->has('research_checkmcu')), 'nullable', 'string', 'max:255'],
            'research_school' => [Rule::requiredIf($request->has('research_checkmcu')), 'nullable', 'string', 'max:255'],
            
            // ✅ ADDED MISSING FILE VALIDATIONS
            'research_Endorsement' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'research_Receipts' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        DB::beginTransaction();

        try {
            // ✅ Save user
            $user_Access = $request->input('user_Access', 'Principal Investigator');
            $user = User::create([
                'user_ID'       => $this->generateCustomID($user_Access),
                'user_Access'   => $user_Access,
                'user_Lname'    => $validate['user_Lname'],
                'user_Fname'    => $validate['user_Fname'],
                'user_MI'       => $validate['user_MI'] ?? null,
                'user_Password' => Hash::make($validate['user_Password']),
                'user_Email'    => $validate['user_Email'],
            ]);

            ProcessMonitoring::create([
            'process_code' => 'PI4',
            'process_description' => 'Registration submitted',
            'user_type' => 'pi',
            'direction' => 'out',
            'timestamp' => now(),
            'action_by_user_id' => $user->user_ID, // The PI who registered
            'action_by_user_type' => 'pi',
            'affected_user_id' => null, // No specific affected user
            'affected_user_type' => null,
        ]);

        // ✅ PROCESS MONITORING: Super Admin Received Request (INCOMING)
        ProcessMonitoring::create([
            'process_code' => 'SA1',
            'process_description' => 'Received request from PI: ' . $user->user_Fname . ' ' . $user->user_Lname,
            'user_type' => 'super_admin',
            'direction' => 'in',
            'timestamp' => now(),
            'action_by_user_id' => $user->user_ID, // The PI who triggered this
            'action_by_user_type' => 'pi',
            'affected_user_id' => null, // All super admins will see this
            'affected_user_type' => 'super_admin',
        ]);

            // ✅ Folder for uploads
            $folderPath = 'researchFolder/' . $user->user_ID;
            Storage::makeDirectory($folderPath);

            // ✅ Handle research_Endorsement file upload
            $research_Endorsement = null;
            if ($request->hasFile('research_Endorsement')) {
                $file = $request->file('research_Endorsement');
                $filename = $user->user_ID . '_endorsement_' . time() . '.' . $file->getClientOriginalExtension();
                $research_Endorsement = $file->storeAs($folderPath, $filename, 'public');
            }

            // ✅ Handle research_Receipts file upload
            $research_Receipts = null;
            if ($request->hasFile('research_Receipts')) {
                $file = $request->file('research_Receipts');
                $filename = $user->user_ID . '_receipt_' . time() . '.' . $file->getClientOriginalExtension();
                $research_Receipts = $file->storeAs($folderPath, $filename, 'public');
            }

            // ✅ Determine school value
            if ($request->has('research_checkmcu')) {
                // Not MCU student
                $research_college = null;
                $research_department = null;
                $research_school = $request->input('research_school');
            } else {
                // MCU student
                $research_college = $request->input('research_college');
                $research_department = $request->input('research_department');
                $research_school = "Manila Central University";
            }

            // ✅ Save Research Information
            ResearchInformation::create([
                'research_info_ID'      => $this->generateResearchInfoID(),
                'user_ID'               => $user->user_ID,
                'research_type'         => $validate['research_type'],
                'research_CoInvestigator'=> $validate['research_CoInvestigator'] ?? null,
                'research_title'        => $validate['research_title'],
                'research_Contact'      => $validate['research_Contact'],
                'research_college'       => $research_college,
                'research_department'    => $research_department,
                'research_school'       => $research_school,
                'research_Endorsement'  => $research_Endorsement,
                'research_Receipts'      => $research_Receipts,
                'research_checkmcu'      => !$request->has('research_checkmcu'),
            ]);

            DB::commit();

            event(new Registered($user));

            $superadmin = User::where('user_Access','Superadmin')->get();

            foreach ($superadmin as $admin) {
                $admin->notify(new NewRegisteredUser($user));
            }

            return redirect()->route('login')->with('success', 'Registration completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    public function addUser(Request $request)
    {
        $validate = $request->validate([
            'user_Fname' => ['required', 'string', 'max:255'],
            'user_Lname' => ['required', 'string', 'max:255'],
            'user_MI' => ['nullable', 'string', 'max:2'], 
            'user_Email' => 'required|email|unique:tbl_users,user_Email',
            'user_Access' => ['nullable'],
        ]);

        $user = new User();
        
        $user_Access = $request->input('user_Access', 'Principal Investigator');
        if (empty($user_Access)) {
            $user_Access = 'Principal Investigator';
        }
        
        // Auto-generate 8-character password
        $autoGeneratedPassword = $this->generateRandomPassword(8);
        
        $user->user_Access = $user_Access;
        $user->user_ID = $this->generateCustomID($user_Access);
        $user->user_Lname = $validate['user_Lname'];
        $user->user_Fname = $validate['user_Fname'];
        $user->user_MI = $validate['user_MI'] ?? null;
        $user->user_Password = Hash::make($autoGeneratedPassword);
        $user->user_Email = $validate['user_Email'];
        $user->save();

        // Send credentials via email using the new Mailable
        try {
            Mail::to($user->user_Email)->send(new NewUserCredential($user, $autoGeneratedPassword));
            $emailSent = true;
        } catch (\Exception $e) {
            Log::error('Failed to send credentials email to ' . $user->user_Email . ': ' . $e->getMessage());
            $emailSent = false;
        }

        if ($request->wantsJson()) {
            $response = [
                'status'  => 'success',
                'message' => 'New user added successfully.',
                'data'    => $user
            ];

            if ($emailSent) {
                $response['message'] .= ' Credentials sent via email.';
            } else {
                $response['message'] .= ' But failed to send email credentials.';
            }

            return response()->json($response, 201);
        }

        $redirectMessage = 'New user added successfully.';
        if ($emailSent) {
            $redirectMessage .= ' Credentials sent via email.';
        } else {
            $redirectMessage .= ' But failed to send email credentials.';
        }

        return redirect()->route('permission-control')
                         ->with('success', $redirectMessage);
    }

    /**
     * Generate random password with 8 characters
     */
    private function generateRandomPassword($length = 8): string
    {
        // Define character sets
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $special = '!@#$%^&*';
        
        // Ensure at least one character from each set
        $password = [
            $lowercase[random_int(0, strlen($lowercase) - 1)],
            $uppercase[random_int(0, strlen($uppercase) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $special[random_int(0, strlen($special) - 1)]
        ];
        
        // Fill the remaining characters
        $allCharacters = $lowercase . $uppercase . $numbers . $special;
        for ($i = count($password); $i < $length; $i++) {
            $password[] = $allCharacters[random_int(0, strlen($allCharacters) - 1)];
        }
        
        // Shuffle the password array and convert to string
        shuffle($password);
        return implode('', $password);
    }
    private function generateCustomID(?string $user_Access): string
    {
        $user_Access = $user_Access ?: 'Principal Investigator';

        $prefixMap = [
            'IACUC Admin' => 'i',
            'ERB Admin' => 'e',
            'Superadmin' => 's',
            'IACUC Reviewer' => 'iR',
            'ERB Reviewer' => 'eR',
            'Principal Investigator' => 'p'
        ];

        $prefix = $prefixMap[$user_Access] ?? 'x';

        $latest = User::where('user_Access', $user_Access)
            ->where('user_ID', 'like', $prefix . '%')
            ->orderByDesc('user_ID')
            ->first();

        if (!$latest) {
            return $prefix . '000001';
        }

    // ✅ use user_ID instead of user_Access
        $number = (int) substr($latest->user_ID, strlen($prefix));
        $next = $number + 1;

        return $prefix . str_pad($next, 6, '0', STR_PAD_LEFT);
    }
    private function generateResearchInfoID()
    {
        // Get the latest research_info_ID
        $lastRecord = ResearchInformation::orderBy('research_info_ID', 'desc')->first();

        if (!$lastRecord) {
            // If no record exists, start at 00001
            $nextNumber = 1;
        } else {
            // Extract the numeric part (after RES-)
            $lastNumber = (int) str_replace('RES-', '', $lastRecord->research_info_ID);
            $nextNumber = $lastNumber + 1;
        }

        // Format with leading zeros (5 digits)
        return 'RES-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
