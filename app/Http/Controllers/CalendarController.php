<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller {
    public function show(Request $req) {
        return view('calendar');
    }
}
