<?php

use App\Http\Controllers\AddAttendeesController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ListAttendeesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterAttendeesController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UploadAttendeesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    // calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');

    // event
    Route::get('/event', [EventController::class, 'index'])->name('event.index');
    Route::post('/event/create', [EventController::class, 'submitEvent'])->name('event.create');

    // instructors
    Route::get('/instructor', [InstructorController::class, 'index'])->name('instructor.index');
    Route::post('/instructor/create', [InstructorController::class, 'submitInstructor'])->name('instructor.create');

    // category
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/category/create', [CategoryController::class, 'submitCategory'])->name('category.create');

    // room
    Route::get('/room', [RoomController::class, 'index'])->name('roomNumber.index');
    Route::post('/room/create', [RoomController::class, 'submitRoomNumber'])->name('roomNumber.create');

    // list attendees
    Route::get('/attendees/list', [ListAttendeesController::class, 'index'])->name('attendees.list.index');

    // add attendees
    Route::get('/attendees/add', [AddAttendeesController::class, 'index'])->name('attendees.add.index');
    Route::post('/attendees/create', [AddAttendeesController::class, 'submitAttendee'])->name('attendees.create');

    // upload attendees
    Route::get('/attendees/upload', [UploadAttendeesController::class, 'index'])->name('attendees.upload.index');
    Route::post('/attendees/import', [UploadAttendeesController::class, 'importAttendee'])->name('attendees.import');

    // Register attendees
    Route::get('/attendees/register', [RegisterAttendeesController::class, 'index'])->name('attendees.register.index');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
