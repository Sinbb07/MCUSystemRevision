<?php

use App\Http\Controllers\AmendmentsERB;
use App\Http\Controllers\assignReviewer;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FormAssignment;
use App\Http\Controllers\MonitoringDashboard;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckReviewerInformation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentDashboard;
use App\Http\Controllers\PdfExportController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\ResearchFileController;
use App\Http\Controllers\ReviewerInformationController;
use App\Http\Controllers\ERBDashboard;
use App\Http\Controllers\ERBReviewer;
use App\Http\Controllers\ERBViewReviews;
use App\Http\Controllers\ERBDecisionController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\FullBoardReview;
use App\Http\Controllers\FinalCompletionController;
use App\Http\Controllers\ProcessMonitoringController;
use App\Http\Controllers\SubmittedInquiries;

// Students Form Controllers
use App\Http\Controllers\Form2AController;
use App\Http\Controllers\Form2BController;
use App\Http\Controllers\Form2CController;
use App\Http\Controllers\Form2DController;
use App\Http\Controllers\Form5EController;
use App\Http\Controllers\Form2EController;
use App\Http\Controllers\Form2JController;
use App\Http\Controllers\Form3AController;
use App\Http\Controllers\Form3BController;
use App\Http\Controllers\Form3DController;
use App\Http\Controllers\Form3EController;
use App\Http\Controllers\Form3CController;
use App\Http\Controllers\Form3LController;

/*
|--------------------------------------------------------------------------
| Public & Session Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('throttle:10,1')->get('/check-session', function () {
    if (Auth::check()) {
        $user = Auth::user();
        $redirectUrl = match ($user->user_Access) {
            'Superadmin' => route('superadmin.dashboard'),
            'ERB Admin' => route('erb.dashboard'),
            'IACUC Admin' => route('iacuc.dashboard'),
            'ERB Reviewer' => route('erb-reviewer.dashboard'),
            'IACUC Reviewer' => route('iacuc-reviewer.dashboard'),
            'Principal Investigator' => route('student.dashboard'),
            default => null,
        };

        return response()->json([
            'loggedIn' => true,
            'redirectUrl' => $redirectUrl
        ]);
    }
    return response()->json(['loggedIn' => false]);
})->name('check-session');

Route::get('/send-otp', function () {
    return view('auth.send-otp');
})->name('send.otp');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');

/*
|--------------------------------------------------------------------------
| ERB Admin Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| ERB Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'access:ERB Admin', 'no-cache', 'prevent-back'])->prefix('erb')->group(function () {
    Route::get('/dashboard', [ERBDashboard::class, 'dashboard'])->name('erb.dashboard');

    // Research Records
    Route::get('/research-records', [ResearchFileController::class, 'researchRecords'])->name('erb.research-records');
    Route::get('/export-form2i', [PdfExportController::class, 'exportForm2I'])->name('export.form2i');
    Route::get('/submitted-documents/{userId}', [ResearchFileController::class, 'submittedDocumentsERB'])->name('erb.submitted-documents');
    Route::post('/research-files/{file}/soft-delete', [ResearchFileController::class, 'softDeleteResearchFile'])->name('research-files.soft-delete');

    // Assignments
    Route::get('/iro-approved-accounts', [FormAssignment::class, 'approvedAccounts'])->name('erb.iro-approved-accounts');
    Route::post('/assign-forms-ajax', [FormAssignment::class, 'assignFormsAjax'])->name('assign.forms.ajax');
    Route::get('/assigned-forms', [FormAssignment::class, 'assignedFormsLogs'])->name('erb.assigned-forms');

    // Reviewer Management
    Route::get('/assign-reviewer', [assignReviewer::class, 'index'])->name('erb.assigned-reviewer');
    Route::post('/assign-reviewer/store', [assignReviewer::class, 'ERBstore'])->name('assign-reviewer.store');
    
    // Decisions & Reviews
    Route::get('/protocol-decision', [ERBDecisionController::class, 'index'])->name('erb.protocol-decision');
    Route::post('/pending-reviews/store', [ERBDecisionController::class, 'store'])->name('erb.pending-reviews.store');
    
    // ✅ Resubmission & Final Completion - GET routes for displaying data
    Route::get('/resubmission', [ERBDecisionController::class, 'resubmission'])->name('erb.resubmission');
    Route::get('/final-completion', [ERBDecisionController::class, 'finalCompletion'])->name('erb.final-completion');
    
    // ✅ KEEP THIS POST ROUTE for the assignment functionality (used in resubmission.blade.php)
    Route::post('/resubmission/assign', [AmendmentsERB::class, 'assignAmendments'])->name('assign.amendments');
    
    Route::get('/view-reviews', [ERBViewReviews::class, 'index'])->name('erb.view-reviews');
    Route::get('/view-review-files/{protocolId}/{reviewerId}', [ERBViewReviews::class, 'showFiles'])->name('erb.view-review-files');

    // Support & Tickets
    Route::get('/submitted-tickets', [SubmittedInquiries::class, 'index'])->name('erb.submitted-tickets');
    Route::get('/tickets/{ticketId}', [SubmittedInquiries::class, 'show'])->name('erb.tickets');

    // Monitoring & Completion
    Route::get('/monitoring-process', [ProcessMonitoringController::class, 'erbindex'])->name('erb.monitoring-process');
    Route::get('/full-board-review', [FullBoardReview::class, 'index'])->name('erb.full-board-review');
    Route::post('/full-board/assign', [FullBoardReview::class, 'store'])->name('full-board.assign');

    // Settings & Notifications
    Route::get('/settings', function () { return view('erb.settings'); })->name('erb.settings');
    Route::post('/notifications/{id}/mark-read', function ($id) {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) { $notification->markAsRead(); }
        return back()->with('success', 'Notification marked as read.');
    })->name('erb.notification.markRead');
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('erb.notification.markAllRead');
});

/*
|--------------------------------------------------------------------------
| IACUC Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'access:IACUC Admin', 'no-cache', 'prevent-back'])->prefix('iacuc')->group(function () {
    Route::get('/dashboard', [ERBDashboard::class, 'iacucDashboard'])->name('iacuc.dashboard');

    // Research & Accounts
    Route::get('/research-records', [ResearchFileController::class, 'researchRecordsIacuc'])->name('iacuc.research-records');
    Route::get('/iro-approved-accounts', [FormAssignment::class, 'IACUCapprovedAccounts'])->name('iacuc.iro-approved-accounts');
    Route::get('/submitted-documents/{userId}', [ResearchFileController::class, 'submittedDocumentsIacuc'])->name('iacuc.submitted-documents');
    Route::post('/assign-default-forms', [FormAssignment::class, 'assignDefaultFormsAjax'])->name('assign.default.forms.ajax');

    // Reviewer & Decisions
    Route::get('/assign-reviewer', [assignReviewer::class, 'iacucIndex'])->name('iacuc.assigned-reviewer');
    Route::post('/assign-reviewer/store', [assignReviewer::class, 'IACUCstore'])->name('iacuc.assign-reviewer.store');
    Route::get('/protocol-decision', [ERBDecisionController::class, 'iacucIndex'])->name('iacuc.protocol-decision');
    Route::post('/pending-reviews/store', [ERBDecisionController::class, 'iacucStoreDecision'])->name('iacuc.pending-reviews.store');
    Route::get('/view-reviews', [ERBViewReviews::class, 'iacucIndex'])->name('iacuc.view-reviews');
    Route::get('/view-review-files/{protocolId}/{reviewerId}', [ERBViewReviews::class, 'iacucShowFiles'])->name('iacuc.view-review-files');

    // Monitoring & Settings
    Route::get('/monitoring-process', [ProcessMonitoringController::class, 'iacucIndex'])->name('iacuc.monitoring-process');
    Route::get('/tickets', function () { return view('iacuc.tickets'); })->name('iacuc.tickets');
    Route::get('/settings', function () { return view('iacuc.settings'); })->name('iacuc.settings');

        // Support & Tickets for IACUC - Use the iacuc methods
        Route::get('/submitted-tickets', [SubmittedInquiries::class, 'index'])->name('iacuc.submitted-tickets');
        Route::get('/tickets/{ticketId}', [SubmittedInquiries::class, 'show'])->name('iacuc.tickets');

    // Notifications
    Route::post('/notifications/{id}/mark-read', function ($id) {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) { $notification->markAsRead(); }
        return back()->with('success', 'Notification marked as read.');
    })->name('iacuc.notification.markRead');
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('iacuc.notification.markAllRead');
});

/*
|--------------------------------------------------------------------------
| Superadmin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'access:Superadmin', 'no-cache', 'prevent-back'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [MonitoringDashboard::class, 'dashboard'])->name('superadmin.dashboard');

    // User Controls
    Route::get('/permission-control', [RegisteredUserController::class, 'index'])->name('permission-control');
    Route::post('/store', [RegisteredUserController::class, 'addUser'])->name('superadmin.store');
    Route::get('/accounts-classifications', [ClassificationController::class, 'index'])->name('accounts-classifications');
    Route::post('/classifications/bulk-update', [ClassificationController::class, 'bulkUpdate'])->name('classifications.bulk-update');

    // Monitoring Logs
    Route::get('/protocol-decision', [MonitoringDashboard::class, 'viewEvaluatedProtocols'])->name('superadmin.protocol-decision');
    Route::get('/assign-reviewer', [MonitoringDashboard::class, 'viewUnassignedReviewer'])->name('superadmin.assign-reviewer');
    Route::get('/research-records', [MonitoringDashboard::class, 'superadminResearchRecords'])->name('superadmin.research-records');
    Route::get('/view-reviews', [MonitoringDashboard::class, 'viewReviews'])->name('superadmin.view-reviews');
    Route::get('/monitoring-process', [ProcessMonitoringController::class, 'index'])->name('superadmin.monitoring-process');
    Route::get('/full-board-review', [MonitoringDashboard::class, 'viewFullBoard'])->name('superadmin.full-board-review');
    Route::get('/final-completion', [MonitoringDashboard::class, 'viewFinalCompletion'])->name('superadmin.final-completion');

    Route::get('/settings', function () { return view('superadmin.settings'); })->name('superadmin.settings');
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('superadmin.notifications.markAllRead');
});

/*
|--------------------------------------------------------------------------
| ERB Reviewer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'access:ERB Reviewer', 'no-cache', 'prevent-back'])->prefix('erb-reviewer')->group(function () {

    // Initial Setup (Outside CheckReviewerInformation middleware to avoid loops)
    Route::get('/college-dept', [ReviewerInformationController::class, 'erbCreate'])->name('erb-reviewer.college-dept');
    Route::post('/college-dept', [ReviewerInformationController::class, 'erbStore'])->name('erb-reviewer.college-dept.store');

    Route::middleware([CheckReviewerInformation::class])->group(function () {
        Route::get('/dashboard', function () { return view('erb-reviewer.dashboard'); })->name('erb-reviewer.dashboard');
        
        // Protocol Management
        Route::get('/protocol-assign', [ERBReviewer::class, 'index'])->name('erb-reviewer.protocol-assign');
        Route::post('/protocol-assign/update-status', [ERBReviewer::class, 'updateReviewStatus'])->name('erb-reviewer.update-status');

        // Forms & Evaluation
        Route::prefix('forms')->group(function () {
            Route::get('/form2e/{protocol?}', [Form2EController::class, 'edit'])->name('form2e.edit');
            Route::post('/form2e', [Form2EController::class, 'store'])->name('form2e.store');
            // Updated route with optional protocol parameter
            Route::get('/export-form2e/{protocolId?}', [PdfExportController::class, 'exportForm2E'])->name('export.form2e');

            Route::get('/form2j/{protocol}', [Form2JController::class, 'edit'])->name('form2j.edit');
            Route::post('/form2j', [Form2JController::class, 'store'])->name('form2j.store');
            // Updated route with optional protocol parameter
            Route::get('/export-form2j/{protocolId?}', [PdfExportController::class, 'exportForm2J'])->name('export.form2j');

            Route::get('/form3e', function () { return view('erb-reviewer.forms.form3e'); })->name('form3e.view');
            Route::get('/form3b', function () { return view('erb-reviewer.forms.form3b'); })->name('form3b.view');
        });

        // Reviewer Submissions
        Route::get('/submitted-documents', [ERBReviewer::class, 'showSubmittedDocuments'])->name('erb-reviewer.submitted-documents');
        Route::get('/submit-documents/{form}', [ERBReviewer::class, 'showSubmitDocuments'])->name('erb-reviewer.submit-documents');
        Route::post('/submit-documents/{form}', [ERBReviewer::class, 'submitForm'])->name('erb-reviewer.submit-documents.store');

        Route::get('/monitoring-process', [ProcessMonitoringController::class, 'erbReviewerIndex'])->name('erb-reviewer.monitoring-process');
        Route::get('/settings', function () { return view('erb-reviewer.settings'); })->name('erb-reviewer.settings');

        // Notifications
        Route::post('/notifications/{id}/mark-read', function ($id) {
            $notification = auth()->user()->notifications()->find($id);
            if ($notification) { $notification->markAsRead(); }
            return back()->with('success', 'Notification marked as read.');
        })->name('erb-reviewer.notification.markRead');
        Route::post('/notifications/mark-all-read', function () {
            auth()->user()->unreadNotifications->markAsRead();
            return back()->with('success', 'All notifications marked as read.');
        })->name('erb-reviewer.notification.markAllRead');
    });
});

/*
|--------------------------------------------------------------------------
| IACUC Reviewer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'access:IACUC Reviewer', 'no-cache', 'prevent-back'])->prefix('iacuc-reviewer')->group(function () {
    
    // Initial Setup
    Route::get('/college-dept', [ReviewerInformationController::class, 'iacucCreate'])->name('iacuc-reviewer.college-dept');
    Route::post('/college-dept', [ReviewerInformationController::class, 'iacucStore'])->name('iacuc-reviewer.college-dept.store');

    Route::middleware([CheckReviewerInformation::class])->group(function () {
        Route::get('/dashboard', [ERBReviewer::class, 'iacucDashboard'])->name('iacuc-reviewer.dashboard');
        
        Route::post('/notification/mark-read/{id}', [ERBReviewer::class, 'markNotificationAsRead'])
            ->name('iacuc-reviewer.notification.markRead');
        Route::post('/notification/mark-all-read', [ERBReviewer::class, 'markAllNotificationsAsRead'])
            ->name('iacuc-reviewer.notification.markAllRead');

        // Protocol Management
        Route::get('/protocol-assign', [ERBReviewer::class, 'iacucIndex'])->name('iacuc-reviewer.protocol-assign');
        Route::post('/protocol-assign/update-status', [ERBReviewer::class, 'updateReviewStatus'])->name('iacuc-reviewer.update-status');

        // Submissions
        Route::get('/submitted-documents', [ERBReviewer::class, 'iacucShowSubmittedDocuments'])->name('iacuc-reviewer.submitted-documents');
        Route::get('/submit-documents/{formId}', [ERBReviewer::class, 'iacucShowSubmitDocuments'])->name('iacuc-reviewer.submit-documents');
        Route::post('/submit-form/{formId}', [ERBReviewer::class, 'iacucSubmitForm'])->name('iacuc-reviewer.submit-form');

        // Forms
        Route::prefix('forms')->group(function () {
            Route::get('/protocol-review', function () { return view('iacuc-reviewer.forms.protocol-review'); })->name('iacuc.protocol-review');
            Route::get('/protocol-review-checklist', [ERBReviewer::class, 'iacucProtocolReviewChecklist'])->name('iacuc-reviewer.protocol-review-checklist');
            Route::post('/protocol-review-checklist', [ERBReviewer::class, 'iacucProtocolReviewChecklistStore'])->name('iacuc-reviewer.protocol-review-checklist.store');
        });

        Route::post('/protocol/update-status', [ERBReviewer::class, 'iacucUpdateReviewStatus'])
        ->name('iacuc-reviewer.update-status');
        
        Route::get('/export-protocol-review-checklist/{protocolId?}', [PdfExportController::class, 'exportProtocolReviewChecklist'])->name('export.protocol-review-checklist');
        Route::get('/monitoring-process', [ProcessMonitoringController::class, 'iacucReviewerIndex'])->name('iacuc-reviewer.monitoring-process');
        Route::get('/settings', function () { return view('iacuc-reviewer.settings'); })->name('iacuc-reviewer.settings');
    });
});

/*
|--------------------------------------------------------------------------
| Principal Investigator (Student) Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'access:Principal Investigator', 'no-cache', 'prevent-back'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('student.dashboard');

    // Document Submissions
    Route::get('/submit-documents', [FormAssignment::class, 'assignedSubmissionDisplay'])->name('student.submit-documents');
    Route::get('/submit-form-layout/{form}', [ResearchFileController::class, 'showForm'])->name('student.submit.form');
    Route::post('/submit-form-layout/{form}/store', [ResearchFileController::class, 'storeSubmission'])->name('student.submit.form.store');
    Route::get('/submit-forms', [FormAssignment::class, 'assignedFormsDisplay'])->name('student.submit-forms');

    // Inquiries & Monitoring
    Route::get('/submit-inquiries', function () { return view('student.submit-inquiries'); })->name('student.submit-inquiries');
    Route::post('/tickets/store', [TicketController::class, 'store'])->name('student.tickets.store');
    Route::get('/monitoring-process', [ProcessMonitoringController::class, 'piIndex'])->name('student.monitoring-process');

    // Forms
    Route::prefix('forms')->group(function () {
        Route::get('/form2a', [Form2AController::class, 'edit'])->name('form2a.edit');
        Route::post('/form2a/store', [Form2AController::class, 'store'])->name('form2a.store');
        Route::get('/export-form2a', [PdfExportController::class, 'exportForm2A'])->name('export.form2a');

        Route::get('/form2b', [Form2BController::class, 'edit'])->name('form2b.edit');
        Route::post('/form2b/store', [Form2BController::class, 'store'])->name('form2b.store');
        Route::get('/export-form2b', [PdfExportController::class, 'exportForm2B'])->name('export.form2b');

        Route::get('/form2c', [Form2CController::class, 'edit'])->name('form2c.edit');
        Route::post('/form2c/store', [Form2CController::class, 'store'])->name('form2c.store');
        Route::get('/export-form2c', [PdfExportController::class, 'exportForm2C'])->name('export.form2c');

        Route::get('/form2d', [Form2DController::class, 'edit'])->name('form2d.edit');
        Route::post('/form2d/store', [Form2DController::class, 'store'])->name('form2d.store');
        Route::get('/export-form2d', [PdfExportController::class, 'exportForm2D'])->name('export.form2d');

        Route::get('/form5e', [Form5EController::class, 'edit'])->name('form5e.edit');
        Route::post('/form5e/store', [Form5EController::class, 'store'])->name('form5e.store');
        Route::get('/export-form5e', [PdfExportController::class, 'exportForm5E'])->name('export.form5e');

        Route::get('/form3a', [Form3AController::class, 'edit'])->name('form3a.edit');
        Route::post('/form3a/store', [Form3AController::class, 'store'])->name('form3a.store');
        Route::get('/export-form3a', [PdfExportController::class, 'exportForm3A'])->name('export.form3a');

        Route::get('/form3b', [Form3BController::class, 'edit'])->name('form3b.edit');
        Route::post('/form3b/store', [Form3BController::class, 'store'])->name('form3b.store');
        Route::get('/export-form3b', [PdfExportController::class, 'exportForm3B'])->name('export.form3b');

        Route::get('/form3c', [Form3CController::class, 'edit'])->name('form3c.edit');
        Route::post('/form3c/store', [Form3CController::class, 'store'])->name('form3c.store');
        Route::get('/export-form3c', [PdfExportController::class, 'exportForm3C'])->name('export.form3c');

        Route::get('/form3d', [Form3DController::class, 'edit'])->name('form3d.edit');
        Route::post('/form3d/store', [Form3DController::class, 'store'])->name('form3d.store');
        Route::get('/export-form3d', [PdfExportController::class, 'exportForm3D'])->name('export.form3d');

        Route::get('/form3e', [Form3EController::class, 'edit'])->name('form3e.edit');
        Route::post('/form3e/store', [Form3EController::class, 'store'])->name('form3e.store');
        Route::get('/export-form3e', [PdfExportController::class, 'exportForm3E'])->name('export.form3e');

        Route::get('/form3l', [Form3LController::class, 'edit'])->name('form3l.edit');
        Route::post('/form3l/store', [Form3LController::class, 'store'])->name('form3l.store');
        Route::get('/export-form3l', [PdfExportController::class, 'exportForm3L'])->name('export.form3l');

        Route::get('/protocol-review', function () { return view('student.forms.protocol-review'); })->name('student.protocol-review');
        Route::get('/export-protocol-review-form', [PdfExportController::class, 'exportProtocolReview'])->name('export.protocol-review-form');
    });

    // Settings & Notifications
    Route::get('/settings', function () { return view('student.settings'); })->name('student.settings');
    Route::post('/notifications/{id}/mark-read', function ($id) {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) { $notification->markAsRead(); }
        return back()->with('success', 'Notification marked as read.');
    })->name('student.notification.markRead');
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('student.notification.markAllRead');
});

/*
|--------------------------------------------------------------------------
| Shared Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'no-cache'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';