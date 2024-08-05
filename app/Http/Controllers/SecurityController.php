<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SecurityController extends Controller
{
    public function index () {
        return Inertia::render('SecurityPage/Scan');
    }
}
