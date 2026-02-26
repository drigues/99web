<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DemoController extends Controller
{
    public function accro(): View
    {
        return view('demo.accro');
    }
}
