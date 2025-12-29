<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class QRTestController extends Controller
{
    public function index()
    {
        return Inertia::render('SelfCheckInUserPage/scanTest');
    }
}
