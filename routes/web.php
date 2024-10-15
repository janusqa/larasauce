<?php

use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('home', [
        "greeting" => "Yo",
        "name" => "Lary Robot",
    ]);
});

Route::get('/jobs', function () {

    // $jobs = Job::all(); // using eloquent orm // lazy loading. Does not fetch employer information
    $jobs = Job::with('employer')->get(); //eager loading. Load emplyer information

    // dd($jobs);

    return view('jobs', [
        "jobs" => $jobs
    ]);
});

Route::get('/jobs/{id}', function ($id) {

    $job = Job::find($id); // using eloquent orm

    return view('job', ["job" => $job]);
});


Route::get('/contact', function () {
    return view('contact');
});
