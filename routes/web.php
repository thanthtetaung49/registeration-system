<?php

use App\Http\Controllers\AddAttendeesController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventListController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ListAttendeesController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\QrcodePrintController;
use App\Http\Controllers\RegisterAttendeesController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UploadAttendeesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegistter' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('/event')->group(function () {
        // event
        Route::get('', [EventController::class, 'index'])->name('event.index');
        Route::post('/create', [EventController::class, 'submitEvent'])->name('event.create');
        // event list
        Route::get('/list', [EventListController::class, 'index'])->name('event.list.index');
        Route::get('/attendees/list/{eventId}', [EventListController::class, 'eventAttendeesList'])->name('event.attendees.list');
    });

    // instructors
    Route::prefix('/instructor')->group(function () {
        Route::get('', [InstructorController::class, 'index'])->name('instructor.index');
        Route::post('/create', [InstructorController::class, 'submitInstructor'])->name('instructor.create');
    });

    // category
    Route::prefix('/category')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/create', [CategoryController::class, 'submitCategory'])->name('category.create');
    });

    // room
    Route::prefix('/room')->group(function () {
        Route::get('', [RoomController::class, 'index'])->name('roomNumber.index');
        Route::post('/create', [RoomController::class, 'submitRoomNumber'])->name('roomNumber.create');
    });

    Route::prefix('/attendees')->group(function () {
        // list attendees
        Route::get('/list', [ListAttendeesController::class, 'index'])->name('attendees.list.index');

        // add attendees
        Route::get('/add', [AddAttendeesController::class, 'index'])->name('attendees.add.index');
        Route::post('/create', [AddAttendeesController::class, 'submitAttendee'])->name('attendees.create');

        // upload attendees
        Route::get('/upload', [UploadAttendeesController::class, 'index'])->name('attendees.upload.index');
        Route::post('/import', [UploadAttendeesController::class, 'importAttendee'])->name('attendees.import');

        // Register attendees
        Route::get('/register', [RegisterAttendeesController::class, 'index'])->name('attendees.register.index');
        Route::post('/event/register', [RegisterAttendeesController::class, 'submitAttendeeEvent'])->name('attendees.register.create');
    });

    // print
    Route::prefix('/print')->group(function () {
        Route::get('', [PrintController::class, 'index'])->name('print.index');
        Route::get('/event/{userId}', [PrintController::class, 'printEvent'])->name('print.event');
        Route::post('', [PrintController::class, 'nameBadgeGenerate'])->name('nameBadge.generate');
    });

    // calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    // pdf print
    Route::get('qrcode/print/{registerEventId}', [QrcodePrintController::class, 'index'])->name('qrcode.print');
});

// qr code registration
Route::get('/qrcode/scan', [QrcodePrintController::class, 'scanQrCode']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
