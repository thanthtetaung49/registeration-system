<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventListController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\PrintBadgeController;
use App\Http\Controllers\EventReportController;
use App\Http\Controllers\QrcodePrintController;
use App\Http\Controllers\AttendeesListController;
use App\Http\Controllers\AttendeesTypeController;
use App\Http\Controllers\AttendeesGroupController;
use App\Http\Controllers\SelfCheckInUserController;
use App\Http\Controllers\UsersManagementController;
use App\Http\Controllers\AttendeesBusinessCardController;
use App\Http\Controllers\AttendeesBusinessCardPublicController;
use App\Http\Controllers\AttendeesController;
use App\Http\Controllers\AttendeesImportController;
use App\Http\Controllers\AttendeesRegisterController;
use App\Http\Controllers\AttendeesUnRegisterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\TeacherTypeController;
use App\Http\Controllers\TrainingListsController;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::prefix('/attendess/business/card/public')->group(function () {
    Route::get('/', [AttendeesBusinessCardPublicController::class, 'index'])->name('businessCard.public.index');
    Route::get('/search', [AttendeesBusinessCardPublicController::class, 'search'])->name('businessCard.search');
    Route::get('/view/{id}', [AttendeesBusinessCardPublicController::class, 'viewPublic'])->name('businessCard.view.public');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/lang/{locale}', [LangController::class, 'index'])->name('lang');

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
        // attendees list
        Route::get('/attendeesLists', [AttendeesListController::class, 'index'])->name('attendees.list.index');
        Route::get('/search', [AttendeesListController::class, 'search'])->name('attendees.search');
        Route::get('/excel/export', [AttendeesListController::class, 'excelExport'])->name('attendees.excel.export');
        Route::get('/csv/export', [AttendeesListController::class, 'csvExport'])->name('attendees.csv.export');

        // attendees
        Route::get('/', [AttendeesController::class, 'index'])->name('attendees.index');
        Route::post('/create', [AttendeesController::class, 'submitAttendee'])->name('attendees.create');
        Route::get('/edit/{user}', [AttendeesController::class, 'edit'])->name('attendees.edit');
        Route::post('/update/{id}', [AttendeesController::class, 'update'])->name('attendees.update');
        Route::get('/view/{id}', [AttendeesController::class, 'view'])->name('attendees.view');
        Route::get('/delete/{id}', [AttendeesController::class, 'delete'])->name('attendees.delete');


        // attendees type
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

        // training lists
        Route::get('/trainingLists', [TrainingListsController::class, 'index'])->name('attendees.trainingLists.index');
        Route::post('/trainingLists/create', [TrainingListsController::class, 'create'])->name('attendees.trainingLists.create');
        Route::get('/trainingLists/edit/{trainingLists}', [TrainingListsController::class, 'edit'])->name('attendees.trainingLists.edit');
        Route::post('/trainingLists/update/{trainingLists}', [TrainingListsController::class, 'update'])->name('attendees.trainingLists.update');
        Route::get('/trainingLists/view/{trainingLists}', [TrainingListsController::class, 'view'])->name('attendees.trainingLists.view');
        Route::get('/trainingLists/delete/{trainingLists}', [TrainingListsController::class, 'delete'])->name('attendees.trainingLists.delete');

        // teacher type
        Route::get('/teacherType', [TeacherTypeController::class, 'index'])->name('attendees.teacherType.index');
        Route::post('/teacherType/create', [TeacherTypeController::class, 'create'])->name('attendees.teacherType.create');
        Route::get('/teacherType/edit/{teacherType}', [TeacherTypeController::class, 'edit'])->name('attendees.teacherType.edit');
        Route::post('/teacherType/update/{teacherType}', [TeacherTypeController::class, 'update'])->name('attendees.teacherType.update');
        Route::get('/teacherType/view/{teacherType}', [TeacherTypeController::class, 'view'])->name('attendees.teacherType.view');
        Route::get('/teacherType/delete/{teacherType}', [TeacherTypeController::class, 'delete'])->name('attendees.teacherType.delete');

        // course
        Route::get('/course', [CourseController::class, 'index'])->name('attendees.course.index');
        Route::post('/course/create', [CourseController::class, 'create'])->name('attendees.course.create');
        Route::get('/course/edit/{course}', [CourseController::class, 'edit'])->name('attendees.course.edit');
        Route::post('/course/update/{course}', [CourseController::class, 'update'])->name('attendees.course.update');
        Route::get('/course/view/{course}', [CourseController::class, 'view'])->name('attendees.course.view');
        Route::get('/course/delete/{course}', [CourseController::class, 'delete'])->name('attendees.course.delete');

        // attendees import
        Route::get('/upload/file', [AttendeesImportController::class, 'index'])->name('attendees.upload.index');
        Route::post('/import', [AttendeesImportController::class, 'importAttendee'])->name('attendees.import');
        Route::get('/template/export', [AttendeesImportController::class, 'export'])->name('attendees.template.export');

        // register attendees
        Route::get('/registerAttendees', [AttendeesRegisterController::class, 'index'])->name('attendees.registerAttendees.index');
        Route::post('/event/registerAttendees/create', [AttendeesRegisterController::class, 'submitAttendeeEvent'])->name('attendees.registerAttendees.create');
        Route::get('/event/registerAttendees/filter', [AttendeesRegisterController::class, 'filterAttendees'])->name('attendees.registerAttendees.filter');
        Route::get('/event/registerAttendees/search', [AttendeesRegisterController::class, 'search'])->name('event.registerAttendees.search');
        Route::get('/event/registerAttendees/Export', [AttendeesRegisterController::class, 'export'])->name('attendees.registerAttendees.export');

        // unregister attendees
        Route::get('/unregisterAttendees', [AttendeesUnRegisterController::class, 'index'])->name('attendees.unregisterAttendees.index');
        Route::post('/event/unregisterAttendees', [AttendeesUnRegisterController::class, 'unregisterEvent'])->name('attendees.unregisterAttendees.unregister');
        Route::get('/event/unregisterAttendees/filter', [AttendeesUnRegisterController::class, 'filterAttendees'])->name('attendees.unregisterAttendees.filter');
        Route::get('/event/unregisterAttendees/search', [AttendeesUnRegisterController::class, 'search'])->name('attendees.unregisterAttendees.search');
    });

    // attendees business card
    Route::get('/attendess/business/card/view/{id}', [AttendeesBusinessCardController::class, 'view'])->name('businessCard.view');

    // print badge
    Route::prefix('/printBadge')->group(function () {
        Route::get('', [PrintBadgeController::class, 'index'])->name('print.index');
        Route::get('/event/{eventId}', [PrintBadgeController::class, 'printEvent'])->name('print.event');
        Route::post('', [PrintBadgeController::class, 'nameBadgeGenerate'])->name('nameBadge.generate');
    });

    // self check In user
    Route::prefix('/selfCheckInUser')->group(function () {
        Route::get('', [SelfCheckInUserController::class, 'index'])->name('selfCheckInUser.index');
        Route::post('/security/QRCode/scan', [SelfCheckInUserController::class, 'SecurityScanQrCode'])->name('selfCheckInUser.security.scan');
        Route::post('/attendees/QRCode/scan', [SelfCheckInUserController::class, 'attendeesScanQrCode'])->name('selfCheckInUser.attendees.scan');
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
