<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AttendeesBusinessCardController extends Controller
{
    public function view($id)
    {
        $user = User::with('attendees_types', 'attendees_groups', 'register_events', 'training_list', 'teacher_type', 'course')->where('id', $id)->first();

        $joinDate = Carbon::parse($user->join_date);
        $currentDate = Carbon::now();
        $diff = $joinDate->diff($currentDate);
        $serviceYears = $diff->y . ' years, ' . $diff->m . ' months, ' . $diff->d . ' days';

        $benefitsPeriodMonths = ["June", "July", "Auguest", "September", "October", "November", "December", "January", "February", "March", "April", "May"];

        $currentMonth = Carbon::now()->format("F");

        $key = array_search($currentMonth, $benefitsPeriodMonths);

        $benefitsValue = $key + 1;

        return Inertia::render('AttendeesBusinessCardPage/AttendeesBusinessCardView', ['user' => $user, 'serviceYears' => $serviceYears, 'baseUrl' => url('/'), 'benefitsValue' => $benefitsValue]);
    }
}
