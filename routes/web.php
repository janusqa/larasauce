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
    // $jobs = Job::with('employer')->get(); //eager loading. Load emplyer information. Use "get" to get all

    // $jobs = Job::with('employer')->paginate(3); // paginate // prev next with numbers

    // simple paginate. Only prev and next // use to increase performance as calculating all those numbers for large set is not performant
    $jobs = Job::with('employer')->latest()->simplePaginate(3);

    // cursor pagination // used also for permarmant pagination.  Still get only prev/next interface
    // the differnce is that the url is not of the form "?page=2" but "?cursor=<jwt-token>".  So no longer can you jump eaisly between
    // pages using url.  This is most performat pagination but the fallback is as described above.
    // $jobs = Job::with('employer')->cursorPaginate(3);

    // dd($jobs);

    return view('jobs/index', [
        "jobs" => $jobs
    ]);
});

Route::get('jobs/create', function () {
    //
    return view('jobs/create');
});

Route::get('/jobs/{id}', function ($id) {

    $job = Job::find($id); // using eloquent orm

    return view('jobs/show', ["job" => $job]);
});

Route::post('/jobs', function () {
    // recall that all of these fields must be in the fillable property of the model to allow record creation like this.
    // This fillable feature can be disabled.
    Job::create([
        "title" => request('title'),
        "salary" => request('salary'),
        "employer_id" => 1
    ]);

    return redirect('/jobs');
});

Route::get('/contact', function () {
    return view('contact');
});
