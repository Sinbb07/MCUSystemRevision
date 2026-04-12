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
use Laravel\Tinker\ClassAliasAutoloader;

//Students Form
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

//data entry
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

// erb - ADDED no-cache MIDDLEWARE
Route::middleware(['auth', 'access:ERB Admin', 'no-cache', 'prevent-back'])->prefix('erb')->group(function () {
    Route::get('/dashboard', [ERBDashboard::class, 'dashboard'])
        ->name('erb.dashboard');

    // Research Records
    Route::get('/research-records', [ResearchFileController::class, 'researchRecords'])
        ->name('erb.research-records');

    Route::get('/export-form2i', [PdfExportController::class, 'exportForm2I'])->name('export.form2i');
    // Submitted Documents for a specific user
    Route::get('/submitted-documents/{userId}', [ResearchFileController::class, 'submittedDocumentsERB'])
        ->name('erb.submitted-documents');

    // In your routes file (web.php)
    Route::post('/research-files/{file}/soft-delete', [ResearchFileController::class, 'softDeleteResearchFile'])
        ->name('research-files.soft-delete');

    Route::get('/iro-approved-accounts', [FormAssignment::class, 'approvedAccounts'])
        ->name('erb.iro-approved-accounts');

    Route::post('/assign-forms-ajax', [FormAssignment::class, 'assignFormsAjax'])
        ->name('assign.forms.ajax');

    // Assigned Forms
    Route::get('/assigned-forms', [FormAssignment::class, 'assignedFormsLogs'])
        ->name('erb.assigned-forms');

    // Protocol Decision
    Route::get('/protocol-decision', [ERBDecisionController::class, 'index'])
        ->name('erb.protocol-decision');

    Route::post('/pending-reviews/store', [ERBDecisionController::class, 'store'])
        ->name('erb.pending-reviews.store');

    // Assign Reviewer
    Route::get('/assign-reviewer', [assignReviewer::class, 'index'])
    ->name('erb.assigned-reviewer');

    Route::post('/assign-reviewer/store', [assignReviewer::class, 'ERBstore'])
        ->name('assign-reviewer.store');

    // View Reviews
    Route::get('/view-reviews', [ERBViewReviews::class, 'index'])
        ->name('erb.view-reviews');

    Route::get('/view-review-files/{protocolId}/{reviewerId}', [ERBViewReviews::class, 'showFiles'])
        ->name('erb.view-review-files');

    // Submitted Tickets
    Route::get('/submitted-tickets', [SubmittedInquiries::class, 'index'])
    ->name('erb.submitted-tickets');

    // Resubmission
    Route::get('/resubmission', [AmendmentsERB::class, 'assignedAmendments'])
        ->name('assigned.amendments');

    Route::post('/resubmission', [AmendmentsERB::class, 'assignAmendments'])
        ->name('assign.amendments');

    // Tickets
    Route::get('/tickets/{ticketId}', [SubmittedInquiries::class, 'show'])
    ->name('erb.tickets');

    // Monitoring Process
    Route::get('/monitoring-process', [ProcessMonitoringController::class, 'erbindex'])
        ->name('erb.monitoring-process');

    // Assign Full Board Review
    Route::get('/full-board-review', [FullBoardReview::class, 'index'])
    ->name('erb.full-board-review');

    Route::post('/full-board/assign', [FullBoardReview::class, 'store'])
    ->name('full-board.assign');

    // Final Completion
    Route::get('/final-completion', [FinalCompletionController::class, 'index'])
    ->name('erb.final-completion');

    // Settings
    Route::get('/settings', function () {
        return view('erb.settings');
    });

    Route::post('/notifications/{id}/mark-read', function ($id) {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return back()->with('success', 'Notification marked as read.');
    })->name('erb.notification.markRead');

    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('erb.notification.markAllRead');
});

// routes ng issuance of cert (nilabas ko lang sa middleware)

// iacuc - ADDED no-cache MIDDLEWARE
Route::middleware(['auth', 'access:IACUC Admin', 'no-cache', 'prevent-back'])->prefix('iacuc')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ERBDashboard::class, 'iacucDashboard'])
    ->name('iacuc.dashboard');

    Route::post('/iacuc/notifications/{id}/mark-read', function ($id) {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return back()->with('success', 'Notification marked as read.');
    })->name('iacuc.notification.markRead');

    Route::post('/iacuc/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('iacuc.notification.markAllRead');
    // Research Records
    Route::get('/research-records', [ResearchFileController::class, 'researchRecordsIacuc'])
        ->name('iacuc.research-records');

    // IRO Approved Accounts
    Route::get('/iro-approved-accounts', [FormAssignment::class, 'IACUCapprovedAccounts'])
        ->name('iacuc.iro-approved-accounts');

    Route::get('/submitted-documents/{userId}', [ResearchFileController::class, 'submittedDocumentsIacuc'])
        ->name('iacuc.submitted-documents');

    Route::post('/assign-default-forms', [FormAssignment::class, 'assignDefaultFormsAjax'])
    ->name('assign.default.forms.ajax');

    // Pending Reviews
    Route::get('/protocol-decision', [ERBDecisionController::class, 'iacucIndex']
    )->name('iacuc.protocol-decision');

    // Assign Reviewer
    Route::get('/assign-reviewer', [assignReviewer::class, 'iacucIndex'])
    ->name('iacuc.assigned-reviewer');

    Route::post('/pending-reviews/store', [ERBDecisionController::class, 'iacucStoreDecision'])
    ->name('iacuc.pending-reviews.store');

    Route::post('/assign-reviewer/store', [assignReviewer::class, 'IACUCstore'])
    ->name('iacuc.assign-reviewer.store');

    // View Reviews
    Route::get('/view-reviews', [ERBViewReviews::class, 'iacucIndex'])->name('iacuc.view-reviews');

    // Settings
    Route::get('/settings', function () {
        return view('iacuc.settings');
    })->name('iacuc.settings');

    // Viewing File
    Route::get('/view-review-files/{protocolId}/{reviewerId}', [ERBViewReviews::class, 'iacucShowFiles'])
        ->name('iacuc.view-review-files');

    // Monitoring Process
    Route::get('/monitoring-process', function() {
        return view('iacuc.monitoring-process');
    });

    Route::get('/tickets', function () {
        return view('iacuc.tickets');
    });
});

// superadmin - ADDED no-cache MIDDLEWARE
Route::middleware(['auth', 'access:Superadmin', 'no-cache', 'prevent-back'])->prefix('superadmin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [MonitoringDashboard::class, 'dashboard'])->name('superadmin.dashboard');

    // Permission control
    Route::get('/permission-control', [RegisteredUserController::class, 'index'])->name('permission-control');
    Route::post('/store', [RegisteredUserController::class, 'addUser'])->name('superadmin.store');

    // Account classification
    Route::get('/accounts-classifications', [ClassificationController::class, 'index'])->name('accounts-classifications');
    Route::post('/classifications/bulk-update', [ClassificationController::class, 'bulkUpdate'])->name('classifications.bulk-update');

    // Other pages
    Route::get('/protocol-decision', [MonitoringDashboard::class, 'viewEvaluatedProtocols'])
        ->name('superadmin.protocol-decision');

    Route::get('/assign-reviewer', [MonitoringDashboard::class, 'viewUnassignedReviewer'])
        ->name('superadmin.assign-reviewer');

    Route::get('/research-records', [MonitoringDashboard::class, 'superadminResearchRecords'])
        ->name('superadmin.research-records');

    Route::get('/view-reviews', [MonitoringDashboard::class, 'viewReviews'])
        ->name('superadmin.view-reviews');

    // cinomment ko muna incase magbago isip HAHAH
    // Route::get('/monitoring', [MonitoringDashboard::class, 'index'])->name('monitoring');

    Route::get('/settings', function () {
        return view('superadmin.settings');
    });

    // Monitoring Process
    Route::get('/monitoring-process', [ProcessMonitoringController::class, 'index'])
        ->name('superadmin.monitoring-process');

    // Full Board Review
    Route::get('/full-board-review', [MonitoringDashboard::class, 'viewFullBoard'])
        ->name('superadmin.full-board-review');

    // Assign Amendments
    /*Route::get('/resubmission', function () {
        return view('superadmin.resubmission');
    });*/

    // Final Completion
    Route::get('/final-completion', [MonitoringDashboard::class, 'viewFinalCompletion'])
        ->name('superadmin.final-completion');

    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('superadmin.notifications.markAllRead');
});

//erb reviewer - ADDED no-cache MIDDLEWARE
Route::middleware(['auth', 'access:ERB Reviewer', CheckReviewerInformation::class, 'no-cache', 'prevent-back'])->prefix('erb-reviewer')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('erb-reviewer.dashboard');
    })->name('erb-reviewer.dashboard');

    // Protocol assignment page
    Route::get('/protocol-assign', [ERBReviewer::class, 'index'])
        ->name('erb-reviewer.protocol-assign');

    Route::post('/notifications/{id}/mark-read', function ($id) {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return back()->with('success', 'Notification marked as read.');
    })->name('erb-reviewer.notification.markRead');

    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('erb-reviewer.notification.markAllRead');
    // Settings
    Route::get('/settings', function () {
        return view('erb-reviewer.settings');
    });
    // Monitoring Process
    Route::get('/monitoring-process', [ProcessMonitoringController::class, 'erbReviewerIndex'])
        ->name('erb-reviewer.monitoring-process');

    Route::prefix('forms')->group(function () {
        Route::get('/form2e', [Form2EController::class, 'edit'])->name('form2e.edit');
        Route::post('/form2e', [Form2EController::class, 'store'])->name('form2e.store');
        Route::get('/export-form2e', [PdfExportController::class, 'exportForm2E'])->name('export.form2e');

        Route::get('/form2j', [Form2JController::class, 'edit'])->name('form2j.edit');
        Route::post('/form2j', [Form2JController::class, 'store'])->name('form2j.store');
        Route::get('/export-form2j', [PdfExportController::class, 'exportForm2J'])->name('export.form2j');

    });

    Route::get('/forms/form3e', function () {
        return view('erb-reviewer.forms.form3e');
    });
    Route::get('/forms/form3b', function () {
        return view('erb-reviewer.forms.form3b');
    });

    // Submission Tab
    Route::get('/submitted-documents', [ERBReviewer::class, 'showSubmittedDocuments'])->name('erb-reviewer.submitted-documents');

    Route::get('/submit-documents/{form}', [ERBReviewer::class, 'showSubmitDocuments'])
        ->name('erb-reviewer.submit-documents');

    Route::post('/submit-documents/{form}', [ERBReviewer::class, 'submitForm'])
        ->name('erb-reviewer.submit-documents.store');
});

Route::middleware(['auth', 'access:ERB Reviewer', 'no-cache', 'prevent-back'])
    ->prefix('erb-reviewer')
    ->group(function () {

        // If reviewer has NOT yet completed college/dept info, show form
        Route::get('/college-dept', [ReviewerInformationController::class, 'erbCreate'])
            ->name('erb-reviewer.college-dept');

        Route::post('/college-dept', [ReviewerInformationController::class, 'erbStore'])
            ->name('erb-reviewer.college-dept.store');
    });

Route::middleware(['auth', 'access:IACUC Reviewer', 'no-cache', 'prevent-back'])
    ->prefix('iacuc-reviewer')
    ->group(function () {

        // If reviewer has NOT yet completed college/dept info, show form
        Route::get('/college-dept', [ReviewerInformationController::class, 'iacucCreate'])
            ->name('iacuc-reviewer.college-dept');

        Route::post('/college-dept', [ReviewerInformationController::class, 'iacucStore'])
            ->name('iacuc-reviewer.college-dept.store');
    });

//iacuc reviewer - ADDED no-cache MIDDLEWARE
Route::middleware(['auth', 'access:IACUC Reviewer',CheckReviewerInformation::class, 'no-cache', 'prevent-back'])->prefix('iacuc-reviewer')->group(function () {
    Route::get('/dashboard', function () {
        return view('iacuc-reviewer.dashboard');
    })->name('iacuc-reviewer.dashboard');

    Route::get('/protocol-assign', [ERBReviewer::class, 'iacucIndex'])
        ->name('iacuc-reviewer.protocol-assign');
    Route::get('/iacuc-reviewer/submitted-documents', [ERBReviewer::class, 'iacucShowSubmittedDocuments'])->name('iacuc-reviewer.submitted-documents');
    Route::get('/iacuc-reviewer/submit-documents/{formId}', [ERBReviewer::class, 'iacucShowSubmitDocuments'])->name('iacuc-reviewer.submit-documents');
    Route::post('/iacuc-reviewer/submit-form/{formId}', [ERBReviewer::class, 'iacucSubmitForm'])->name('iacuc-reviewer.submit-form');

    Route::get('/settings', function () {
        return view('iacuc-reviewer.settings');
    });

    Route::get('/monitoring-process', function() {
        return view('iacuc-reviewer.monitoring-process');
    });

    Route::get('/forms/protocol-review', function () {
        return view('iacuc-reviewer.forms.protocol-review');
    });

    Route::get('/forms/protocol-review-checklist', function () {
        return view('iacuc-reviewer.forms.protocol-review-checklist');
    });

    Route::get('/export-protocol-review-checklist', [PdfExportController::class, 'exportProtocolReviewChecklist'])->name('export.protocol-review-checklist');
});

// student - ADDED no-cache MIDDLEWARE
Route::middleware(['auth', 'access:Principal Investigator', 'no-cache', 'prevent-back'])->prefix('student')->group(function () {

    Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('student.dashboard');

    Route::get('/submit-documents', [FormAssignment::class, 'assignedSubmissionDisplay'])
        ->name('student.submit-documents');

    Route::get('/submit-form-layout/{form}', [ResearchFileController::class, 'showForm'])
        ->name('student.submit.form');

    Route::post('/submit-form-layout/{form}/store', [ResearchFileController::class, 'storeSubmission'])
        ->name('student.submit.form.store');

    Route::get('/submit-inquiries', function () {
        return view('student.submit-inquiries');
    });

    Route::get('/submit-forms', [FormAssignment::class, 'assignedFormsDisplay'])
        ->name('student.submit-forms');

    Route::get('/settings', function () {
        return view('student.settings');
    });

    Route::get('/monitoring-process', [ProcessMonitoringController::class, 'piIndex'])
        ->name('student.monitoring-process');

    Route::post('/tickets/store', [TicketController::class, 'store'])
        ->name('student.tickets.store');

    Route::post('/notifications/{id}/mark-read', function ($id) {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return back()->with('success', 'Notification marked as read.');
    })->name('student.notification.markRead');

    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('student.notification.markAllRead');

    // sample form layout
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

        Route::get('/form3e', [Form3DController::class, 'edit'])->name('form3e.edit');
        Route::post('/form3e/store', [Form3DController::class, 'store'])->name('form3e.store');
        Route::get('/export-form3e', [PdfExportController::class, 'exportForm3E'])->name('export.form3e');

        Route::get('/form3l', [Form3LController::class, 'edit'])->name('form3l.edit');
        Route::post('/form3l/store', [Form3LController::class, 'store'])->name('form3l.store');
        Route::get('/export-form3l', [PdfExportController::class, 'exportForm3L'])->name('export.form3l');

        Route::get('/protocol-review', function () {
            return view('student.forms.protocol-review');
        });

        Route::get('/export-protocol-review-form', [PdfExportController::class, 'exportProtocolReview'])->name('export.protocol-review-form');
    });
});



//Verification for login

//Storing Data for Form2A
//Route::get('/student/download-forms', [Form2AController::class, 'index'])->name('download-forms');

//pdf exporter


// Profile routes - ADDED no-cache MIDDLEWARE
Route::middleware(['auth', 'no-cache'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';