<?php

if (!function_exists('time_now')) {
    function time_now() {
        
        if (session()->has('manipulated_time')) {
            return \Carbon\Carbon::parse(session('manipulated_time'));
        }
        return now();
    }
}