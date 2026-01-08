<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

class LangController extends Controller
{
    public function index(string $locale)
    {
        if (! in_array($locale, ['en', 'mm'])) {
            abort(400);
        }

        session()->put('locale', $locale);
    }
}
