<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\EventListController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\EventReportController;
use App\Http\Controllers\QrcodePrintController;
use App\Http\Controllers\AddAttendeesController;
use App\Http\Controllers\AttendeesTypeController;
use App\Http\Controllers\ListAttendeesController;
use App\Http\Controllers\AttendeesGroupController;
use App\Http\Controllers\UploadAttendeesController;
use App\Http\Controllers\RegisterAttendeesController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\UnregisterAttendeesController;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegistter' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/test', function () {
    return '<img src="'.asset('img/car.jpg').'" />';
});

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    Route::prefix('/event')->group(function () {
        // event
        Route::get('', [EventController::class, 'index'])->name('event.index');
        Route::post('/create', [EventController::class, 'submitEvent'])->name('event.create');

        // event list
        Route::get('/list', [EventListController::class, 'index'])->name('event.list.index');
        Route::get('/list/view/{eventId}', [EventListController::class, 'view'])->name('event.list.view');
        Route::get('/list/edit/{eventId}', [EventListController::class, 'edit'])->name('event.list.edit');
        Route::post('/list/update/{event}', [EventListController::class, 'update'])->name('event.list.update');
        Route::get('/list/delete/{event}', [EventListController::class, 'delete'])->name('event.list.delete');
        Route::get('/search', [EventListController::class, 'search'])->name('event.search');
        Route::get('/attendees/list/{eventId}', [EventListController::class, 'eventAttendeesList'])->name('event.attendees.list');
        Route::get('/type2/qrcode/generate/{eventId}', [EventListController::class, 'eventType2QrcodeGenerate'])->name('event.type2.qrcode');

        // event report
        Route::get('/report', [EventReportController::class, 'index'])->name('event.report.index');
        Route::get('/report/search', [EventReportController::class, 'search'])->name('event.report.search');
        Route::get('/report/checkin/excel/export', [EventReportController::class, 'excelExport'])->name('checkin.excel.report');
    });

    // instructors
    Route::prefix('/instructor')->group(function () {
        Route::get('', [InstructorController::class, 'index'])->name('instructor.index');
        Route::post('/create', [InstructorController::class, 'submitInstructor'])->name('instructor.create');
        Route::get('/edit/{instructor}', [InstructorController::class, 'edit'])->name('instructor.edit');
        Route::post('/update/{instructor}', [InstructorController::class, 'update'])->name('instructor.update');
        Route::get('/view/{instructor}', [InstructorController::class, 'view'])->name('instructor.view');
        Route::get('/delete/{instructor}', [InstructorController::class, 'delete'])->name('instructor.delete');
    });

    // category
    Route::prefix('/category')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/create', [CategoryController::class, 'submitCategory'])->name('category.create');
        Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{category}', [CategoryController::class, 'update'])->name('category.update');
        Route::get('/view/{category}', [CategoryController::class, 'view'])->name('category.view');
        Route::get('/delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');
    });

    // room
    Route::prefix('/room')->group(function () {
        Route::get('', [RoomController::class, 'index'])->name('roomNumber.index');
        Route::post('/create', [RoomController::class, 'submitRoomNumber'])->name('roomNumber.create');
        Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('roomNumber.edit');
        Route::post('/update/{room}', [RoomController::class, 'update'])->name('roomNumber.update');
        Route::get('/view/{room}', [RoomController::class, 'view'])->name('roomNumber.view');
        Route::get('/delete/{room}', [RoomController::class, 'delete'])->name('roomNumber.delete');
    });

    Route::prefix('/attendees')->group(function () {
        // list
        Route::get('/list', [ListAttendeesController::class, 'index'])->name('attendees.list.index');
        Route::get('/search', [ListAttendeesController::class, 'search'])->name('attendees.search');
        Route::get('/list/excel/export', [ListAttendeesController::class, 'excelExport'])->name('attendees.excel.export');
        Route::get('/list/csv/export', [ListAttendeesController::class, 'csvExport'])->name('attendees.csv.export');
        // Route::get('/duplicate/check', [ListAttendeesController::class, 'duplicate'])->name('duplicate.check');

        // type
        Route::get('/type', [AttendeesTypeController::class, 'index'])->name('attendees.type.index');
        Route::post('/type/create', [AttendeesTypeController::class, 'create'])->name('attendees.type.create');
        Route::get('/type/edit/{attendeesType}', [AttendeesTypeController::class, 'edit'])->name('attendees.type.edit');
        Route::post('/type/update/{attendeesType}', [AttendeesTypeController::class, 'update'])->name('attendees.type.update');
        Route::get('/type/view/{attendeesType}', [AttendeesTypeController::class, 'view'])->name('attendees.type.view');
        Route::get('/type/delete/{attendeesType}', [AttendeesTypeController::class, 'delete'])->name('attendees.type.delete');

        // attendees group
        Route::get('/group', [AttendeesGroupController::class, 'index'])->name('attendees.group.index');
        Route::post('/group/create', [AttendeesGroupController::class, 'create'])->name('attendees.group.create');
        Route::get('/group/edit/{attendeesGroup}', [AttendeesGroupController::class, 'edit'])->name('attendees.group.edit');
        Route::post('/group/update/{attendeesGroup}', [AttendeesGroupController::class, 'update'])->name('attendees.group.update');
        Route::get('/group/view/{attendeesGroup}', [AttendeesGroupController::class, 'view'])->name('attendees.group.view');
        Route::get('/group/delete/{attendeesGroup}', [AttendeesGroupController::class, 'delete'])->name('attendees.group.delete');

        // add
        Route::get('/add', [AddAttendeesController::class, 'index'])->name('attendees.index');
        Route::post('/create', [AddAttendeesController::class, 'submitAttendee'])->name('attendees.create');
        Route::get('/edit/{user}', [AddAttendeesController::class, 'edit'])->name('attendees.edit');
        Route::post('/update/{id}', [AddAttendeesController::class, 'update'])->name('attendees.update');
        Route::get('/view/{id}', [AddAttendeesController::class, 'view'])->name('attendees.view');
        Route::get('/delete/{id}', [AddAttendeesController::class, 'delete'])->name('attendees.delete');

        // upload and  import
        Route::get('/upload', [UploadAttendeesController::class, 'index'])->name('attendees.upload.index');
        Route::post('/import', [UploadAttendeesController::class, 'importAttendee'])->name('attendees.import');
        Route::get('/template/export', [UploadAttendeesController::class, 'export'])->name('attendees.template.export');

        // register
        Route::get('/register', [RegisterAttendeesController::class, 'index'])->name('attendees.register.index');
        Route::post('/event/register', [RegisterAttendeesController::class, 'submitAttendeeEvent'])->name('attendees.register.create');
        Route::get('/event/register/filter', [RegisterAttendeesController::class, 'filterAttendees'])->name('attendees.filter');
        Route::get('/event/register/search', [RegisterAttendeesController::class, 'search'])->name('event.register.search');
        Route::get('/event/registerAttendees/Export', [RegisterAttendeesController::class, 'export'])->name('attendees.register.export');

        // unregister
        Route::get('/unregister', [UnregisterAttendeesController::class, 'index'])->name('attendees.unregister.index');
        Route::post('/event/unregister', [UnregisterAttendeesController::class, 'unregisterEvent'])->name('attendees.unregister.delete');
        Route::get('/event/unregister/filter', [UnregisterAttendeesController::class, 'filterAttendees'])->name('unregister.filter');
        Route::get('/event/unregister/search', [UnregisterAttendeesController::class, 'search'])->name('unregister.search');
    });

    // print
    Route::prefix('/print')->group(function () {
        Route::get('', [PrintController::class, 'index'])->name('print.index');
        Route::get('/event/{eventId}', [PrintController::class, 'printEvent'])->name('print.event');
        Route::post('', [PrintController::class, 'nameBadgeGenerate'])->name('nameBadge.generate');
    });

    // security
    Route::prefix('/scan')->group(function () {
        Route::get('', [SecurityController::class, 'index'])->name('scan.index');
    });

    // qrcode scan
    Route::post('/security/qrcode/scan', [ScannerController::class, 'SecurityScanQrCode']);
    Route::post('/student/qrcode/scan', [ScannerController::class, 'SelfCheckinScanQrCode']);

    // qrcode download
    Route::get('attendees/qrcode/download/{registerEventId}', [QrcodePrintController::class, 'attendeesQrcodeIndex'])->name('attendees.qrcode.print');
    Route::get('event/qrcode/download/{eventId}', [QrcodePrintController::class, 'eventQrcodeIndex'])->name('event.qrcode.print');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
