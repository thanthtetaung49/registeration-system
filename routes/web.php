<?php

use App\Http\Controllers\UsersManagementController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\EventListController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\EventReportController;
use App\Http\Controllers\QrcodePrintController;
use App\Http\Controllers\AddAttendeesController;
use App\Http\Controllers\AttendeesBusinessCardController;
use App\Http\Controllers\AttendeesCreateController;
use App\Http\Controllers\AttendeesTypeController;
use App\Http\Controllers\ListAttendeesController;
use App\Http\Controllers\AttendeesGroupController;
use App\Http\Controllers\AttendeesListController;
use App\Http\Controllers\ImportAttendeesController;
use App\Http\Controllers\PrintBadgeController;
use App\Http\Controllers\UploadAttendeesController;
use App\Http\Controllers\RegisterAttendeesController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\UnregisterAttendeesController;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    Route::prefix('/users')->group(function () {
        // users management
        Route::get('/', [UsersManagementController::class, 'index'])->name('users.management');
        Route::get('/edit/{user}', [UsersManagementController::class, 'edit'])->name('users.management.edit');
        Route::post('/update/{user}', [UsersManagementController::class, 'update'])->name('users.management.update');
        Route::get('/view/{user}', [UsersManagementController::class, 'view'])->name('users.management.view');
        Route::post('/role/update', [UsersManagementController::class, 'roleUpdate'])->name('users.management.role.update');
        Route::get('/search', [UsersManagementController::class, 'search'])->name('users.management.search');
        Route::post('/user/diabled', [UsersManagementController::class, 'disabledUser'])->name('users.management.disabled');
        Route::post('/user/activate', [UsersManagementController::class, 'activateUser'])->name('users.management.disabled');
        Route::post('/user/delete', [UsersManagementController::class, 'deleteUser'])->name('users.management.disabled');
    });

    Route::prefix('/event')->group(function () {
        // event
        Route::get('/', [EventController::class, 'index'])->name('event.index');
        Route::post('/create', [EventController::class, 'submitEvent'])->name('event.create');

        // event list
        Route::get('/eventList', [EventListController::class, 'index'])->name('event.list.index');
        Route::get('/eventList/view/{eventId}', [EventListController::class, 'view'])->name('event.list.view');
        Route::get('/eventList/edit/{eventId}', [EventListController::class, 'edit'])->name('event.list.edit');
        Route::post('/eventList/update/{event}', [EventListController::class, 'update'])->name('event.list.update');
        Route::get('/eventList/delete/{event}', [EventListController::class, 'delete'])->name('event.list.delete');
        Route::get('/search', [EventListController::class, 'search'])->name('event.search');

        // event attendees list
        Route::get('/eventList/eventAttendeesList/{eventId}', [EventListController::class, 'eventAttendeesList'])->name('event.attendees.list');
        Route::get('/eventList/selfCheckInUser/QRCode/generate/{eventId}', [EventListController::class, 'selfCheckInUserQRCodeGenerate'])->name('event.selfCheckInUser.QRCodeGenerate');

        // event report
        Route::get('/report', [EventReportController::class, 'index'])->name('event.report.index');
        Route::get('/report/search', [EventReportController::class, 'search'])->name('event.report.search');
        Route::get('/report/checkin/excel/export', [EventReportController::class, 'excelExport'])->name('checkin.excel.report');
    });

    // instructors
    Route::prefix('/instructors')->group(function () {
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
        Route::get('/attendeesLists', [AttendeesListController::class, 'index'])->name('attendees.list.index');
        Route::get('/search', [AttendeesListController::class, 'search'])->name('attendees.search');
        Route::get('/excel/export', [AttendeesListController::class, 'excelExport'])->name('attendees.excel.export');
        Route::get('/csv/export', [AttendeesListController::class, 'csvExport'])->name('attendees.csv.export');

        // type
        Route::get('/attendeesType', [AttendeesTypeController::class, 'index'])->name('attendees.type.index');
        Route::post('/attendeesType/create', [AttendeesTypeController::class, 'create'])->name('attendees.type.create');
        Route::get('/attendeesType/edit/{attendeesType}', [AttendeesTypeController::class, 'edit'])->name('attendees.type.edit');
        Route::post('/attendeesType/update/{attendeesType}', [AttendeesTypeController::class, 'update'])->name('attendees.type.update');
        Route::get('/attendeesType/view/{attendeesType}', [AttendeesTypeController::class, 'view'])->name('attendees.type.view');
        Route::get('/attendeesType/delete/{attendeesType}', [AttendeesTypeController::class, 'delete'])->name('attendees.type.delete');

        // attendees group
        Route::get('/attendeesGroup', [AttendeesGroupController::class, 'index'])->name('attendees.group.index');
        Route::post('/attendeesGroup/create', [AttendeesGroupController::class, 'create'])->name('attendees.group.create');
        Route::get('/attendeesGroup/edit/{attendeesGroup}', [AttendeesGroupController::class, 'edit'])->name('attendees.group.edit');
        Route::post('/attendeesGroup/update/{attendeesGroup}', [AttendeesGroupController::class, 'update'])->name('attendees.group.update');
        Route::get('/attendeesGroup/view/{attendeesGroup}', [AttendeesGroupController::class, 'view'])->name('attendees.group.view');
        Route::get('/attendeesGroup/delete/{attendeesGroup}', [AttendeesGroupController::class, 'delete'])->name('attendees.group.delete');

        // add
        Route::get('/', [AttendeesCreateController::class, 'index'])->name('attendees.index');
        Route::post('/create', [AttendeesCreateController::class, 'submitAttendee'])->name('attendees.create');
        Route::get('/edit/{user}', [AttendeesCreateController::class, 'edit'])->name('attendees.edit');
        Route::post('/update/{id}', [AttendeesCreateController::class, 'update'])->name('attendees.update');
        Route::get('/view/{id}', [AttendeesCreateController::class, 'view'])->name('attendees.view');
        Route::get('/delete/{id}', [AttendeesCreateController::class, 'delete'])->name('attendees.delete');

        // upload and  import
        Route::get('/upload/file', [ImportAttendeesController::class, 'index'])->name('attendees.upload.index');
        Route::post('/import', [ImportAttendeesController::class, 'importAttendee'])->name('attendees.import');
        Route::get('/template/export', [ImportAttendeesController::class, 'export'])->name('attendees.template.export');

        // register
        Route::get('/registerAttendees', [RegisterAttendeesController::class, 'index'])->name('attendees.registerAttendees.index');
        Route::post('/event/registerAttendees/create', [RegisterAttendeesController::class, 'submitAttendeeEvent'])->name('attendees.registerAttendees.create');
        Route::get('/event/registerAttendees/filter', [RegisterAttendeesController::class, 'filterAttendees'])->name('attendees.registerAttendees.filter');
        Route::get('/event/registerAttendees/search', [RegisterAttendeesController::class, 'search'])->name('event.registerAttendees.search');
        Route::get('/event/registerAttendees/Export', [RegisterAttendeesController::class, 'export'])->name('attendees.registerAttendees.export');

        // unregister
        Route::get('/unregisterAttendees', [UnregisterAttendeesController::class, 'index'])->name('attendees.unregisterAttendees.index');
        Route::post('/event/unregisterAttendees', [UnregisterAttendeesController::class, 'unregisterEvent'])->name('attendees.unregisterAttendees.unregister');
        Route::get('/event/unregisterAttendees/filter', [UnregisterAttendeesController::class, 'filterAttendees'])->name('attendees.unregisterAttendees.filter');
        Route::get('/event/unregisterAttendees/search', [UnregisterAttendeesController::class, 'search'])->name('attendees.unregisterAttendees.search');
    });

    // business card
    Route::prefix('/attendess/business/card')->group(function () {
        Route::get('/', [AttendeesBusinessCardController::class, 'index'])->name('businessCard.index');
        Route::get('/view/{id}', [AttendeesBusinessCardController::class, 'view'])->name('businessCard.view');
        Route::get('/search', [AttendeesBusinessCardController::class, 'search'])->name('businessCard.search');
    });

    // print
    Route::prefix('/printBadge')->group(function () {
        Route::get('', [PrintBadgeController::class, 'index'])->name('print.index');
        Route::get('/event/{eventId}', [PrintBadgeController::class, 'printEvent'])->name('print.event');
        Route::post('', [PrintBadgeController::class, 'nameBadgeGenerate'])->name('nameBadge.generate');
    });

    // self check In user
    Route::prefix('/selfCheckInUser')->group(function () {
        Route::get('', [SecurityController::class, 'index'])->name('selfCheckInUser.index');
        Route::post('/security/QRCode/scan', [ScannerController::class, 'SecurityScanQrCode'])->name('selfCheckInUser.security.scan');
        Route::post('/attendees/QRCode/scan', [ScannerController::class, 'SelfCheckinScanQrCode'])->name('selfCheckInUser.attendees.scan');
    });

    // QRCode download
    Route::get('/attendees/QRCode/download/{registerEventId}', [QrcodePrintController::class, 'attendeesQrcodeIndex'])->name('attendees.QRCode.print');
    Route::get('event/QRCode/download/{eventId}', [QrcodePrintController::class, 'eventQrcodeIndex'])->name('event.QRCode.print');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
