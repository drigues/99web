<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DemoController extends Controller
{
    public function acccro(): View
    {
        return view('demo.accro');
    }
}
