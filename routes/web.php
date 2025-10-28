<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StaffSummaryReportController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\DentalRecordController;
use App\Http\Controllers\InventoryReportController;
use App\Http\Controllers\UserRoleController;
use App\Livewire\AdminDoctorSchedule;

$url = config('app.url');
URL::forceRootUrl($url);

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->hasRole('clinic staff')) {
            return redirect()->route('summary-report');
        } elseif ($user->hasRole('patient')) {
            return redirect()->route('patient-homepage');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('admin'); // redirect admin to Manage Doctors page
        }

        abort(403, 'Unauthorized action.');
        
    })->name('dashboard');

    // Staff dashboard route
    Route::get('/staff/dashboard', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403); // Forbidden
        }
        return view('staff-dashboard');
    })->name('staff-dashboard');

    // Patient homepage route
    Route::get('/homepage', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('patient')) {
            abort(403); // Forbidden
        }
        return view('welcome');
    })->name('patient-homepage');

    // Appointment route
    Route::get('/appointment', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('patient')) {
            abort(403); // Forbidden
        }
        return view('patient-calendar');
    })->name('appointment');

    
   // Invetory Report ROUTE FOR PDF
    Route::post('/inventory/report', [InventoryReportController::class, 'generate'])->name('inventory.report');
    // Dental form route
    // Route::get('/staff/dental-form', function () {
    //     $user = Auth::user();
    //     if (!$user || !$user->hasRole('clinic staff')) {
    //         abort(403); // Forbidden
    //     }
    //     return view('dental-form');
    // })->name('dental-form');

    Route::get('/staff/dental-form', function (Illuminate\Http\Request $request) {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403);
        }
    
        return view('dental-form', [
            'appointment_id' => $request->query('appointment_id'),
            'fromStaffCalendar' => $request->query('fromStaffCalendar', false)
        ]);
    })->name('dental-form');


    // Dental records table route
    Route::get('/staff/dental-records-table', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403); // Forbidden
        }
        return view('dental-records-table');
    })->name('dental-records-table');

    Route::get('/staff/dental-records/{id}', [DentalRecordController::class, 'view'])
    ->name('view-dental-record');

    Route::post('/appointment/notif', [AppointmentController::class, 'store'])
    ->name('appointment.notif')
    ->middleware('auth');

    // Inventory route
    Route::get('/staff/inventory', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403); // Forbidden    
        }
        return view('medical-inventory');
    })->name('medical-inventory');

    // Medical Inventory Dashboard
    Route::get('/staff/inventory', function () {
    $user = Auth::user();
    if (!$user || !$user->hasRole('clinic staff')) {
        abort(403);    
    }
    return view('medical-inventory');
    })->name('medical-inventory');

    // Inventory Summary / Report Page
    Route::get('/staff/inventory-summary', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403); // Forbidden    
        }

        $duration = request()->query('duration', 'monthly');
        $sections = request()->query('sections', ['Actual Stocks', 'General Issuance']);

        // Fetch all medicines
        $medicines = DB::table('supplies')->orderBy('name')->get();

        return view('inventory-summary', compact('duration', 'sections', 'medicines'));
    })->name('inventory.summary');

    // PDF Generation Route
    Route::get('/staff/inventory-report', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403); // Forbidden
        }

        // Forward the request to the controller
        return app(InventoryReportController::class)->generate(request());
    })->name('inventory.report');

    // Medical records route
    Route::get('/staff/medical-records', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403); // Forbidden
        }
        return view('medical-records');
    })->name('medical-records');

    Route::get('/addRecordmain', [MedicalRecordController::class, 'create'])
    ->name('add-medical-record');

    Route::get('/medical-records/{id}', [MedicalRecordController::class, 'view'])
    ->name('view-medical-record');

    Route::get('/archived-records', [MedicalRecordController::class, 'archiveRecord'])
    ->name('archived-records');


    // Summary report route
    // Route::get('/staff/summary-report', function () {
    //     $user = Auth::user();
    //     if (!$user || !$user->hasRole('clinic staff')) {
    //         abort(403); // Forbidden
    //     }
    //     return view('staff-summary-report');
    // })->name('summary-report');

    Route::get('/staff/summary-report', [StaffSummaryReportController::class, 'index'])->name('summary-report');

    Route::get('/staff/generate-accomplishment-report', 
        [StaffSummaryReportController::class, 'generateAccomplishmentReport'])
        ->name('generate.accomplishment.report');


    // Calendar route
    Route::get('/staff/calendar', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403); // Forbidden
        }
        return view('staff-calendar');
    })->name('calendar');

    // Appointment History route
    Route::get('/appointment-history', [AppointmentController::class, 'showAppointmentHistory'])
    ->name('appointment-history');

    Route::get('/print-medical-record/{appointmentId}', [MedicalRecordController::class, 'printMedicalRecord'])->name('print.medical.record');
    

    // Add Record route  
    Route::get('/staff/add-record', function (Illuminate\Http\Request $request) {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403);
        }
    
        return view('addRecordmain', [
            'appointment_id' => $request->query('appointment_id'),
            'fromStaffCalendar' => $request->query('fromStaffCalendar', false)
        ]);
    })->name('addRecordmain');

     // Test route
    Route::get('/staff/medformv2', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403); // Forbidden
        }
        return view('medformv2');
    })->name('medformv2');

    // Add Medicine route
    Route::get('/staff/add-medicine', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('clinic staff')) {
            abort(403); // Forbidden
        }
        return view('add-medicine');
    })->name('add-medicine');

    // Generate Inventory Route
    Route::get('/inventory/report', [InventoryController::class, 'generateReport'])
    ->name('inventory.report');

    // About us
    Route::get('/about-us', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('patient')) {
            abort(403); // Forbidden
        }
        return view('about-us');
    })->name('about-us');

    Route::get('staff/medical-records/{id}/print', [MedicalRecordController::class, 'printMedicalRecord'])
        ->name('print-medical-record');

    // About us Button Route
    Route::get('/about-us', function () {
        return view('about-us');
    })->name('about');

    Route::post('/staff/inventory/add', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/staff/inventory/{id}', [InventoryController::class, 'show'])->name('inventory.show');

    // Feedback route
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    Route::get('/generate-accomplishment-report', 
        [App\Http\Controllers\StaffSummaryReportController::class, 'generateAccomplishmentReport']
    )->name('generate.accomplishment.report');

    // Print dental record route
    Route::get('/dental-records/{id}/print', [DentalRecordController::class, 'printPDF'])
    ->name('print-dental-record');

    Route::get('/admin', [UserRoleController::class, 'index'])->name('admin');

    Route::get('/admin/roles/search', [UserRoleController::class, 'search'])
    ->name('admin.roles.search');

    Route::post('/admin/assign-role/{user}', [UserRoleController::class, 'assignRole'])
    ->name('admin.assignRole');

    Route::get('/admin/doctor-schedule', function () {
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin')) {
            abort(403); // Forbidden
        }
        return view('admin-doctor-schedule');
    })->name('admin.doctor-schedule');
});

