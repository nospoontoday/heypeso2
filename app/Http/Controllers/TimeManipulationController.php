<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeManipulationController extends Controller
{
    public function index()
    {
        return view('time-manipulation');
    }

    public function manipulate(Request $request)
    {
        $request->validate([
            'add_days' => 'nullable|integer|min:0|max:365',
            'add_hours' => 'nullable|integer|min:0|max:1000',
        ]);

        $manipulatedTime = now()->addDays((int)($request->add_days ?? 0))->addHours((int)($request->add_hours ?? 0));

        session(['manipulated_time' => $manipulatedTime->toDateTimeString()]);

        return redirect()->route('time.manipulation')->with('success', 'Time manipulated successfully.');
    }

    public function reset()
    {
        session()->forget('manipulated_time');

        return redirect()->route('time.manipulation')->with('success', 'Time reset to current.');
    }
}
