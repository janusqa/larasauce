<?php

use App\Http\Controllers\JobController;
use App\Models\Job;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('home', [
        "greeting" => "Yo",
        "name" => "Lary Robot",
    ]);
});
// Route::view('/', 'home'); // short nand method for the above route that just returns a static view

// Index with inline function closure
// Route::get('/jobs', function () {

//     // $jobs = Job::all(); // using eloquent orm // lazy loading. Does not fetch employer information
//     // $jobs = Job::with('employer')->get(); //eager loading. Load emplyer information. Use "get" to get all

//     // $jobs = Job::with('employer')->paginate(3); // paginate // prev next with numbers

//     // simple paginate. Only prev and next // use to increase performance as calculating all those numbers for large set is not performant
//     $jobs = Job::with('employer')->latest()->simplePaginate(3);

//     // cursor pagination // used also for permarmant pagination.  Still get only prev/next interface
//     // the differnce is that the url is not of the form "?page=2" but "?cursor=<jwt-token>".  So no longer can you jump eaisly between
//     // pages using url.  This is most performat pagination but the fallback is as described above.
//     // $jobs = Job::with('employer')->cursorPaginate(3);

//     // dd($jobs);

//     return view('jobs/index', [
//         "jobs" => $jobs
//     ]);
// });

// Index with controller
Route::get("/jobs", [JobController::class, "index"]);

// Create
// Route::get('jobs/create', function () {
//     //
//     return view('jobs/create');
// });

// Create with controller
Route::get('jobs/create', [JobController::class, "create"]);

// Edit
// Route::get('/jobs/{id}/edit', function ($id) {

//     $job = Job::find($id); // using eloquent orm

//     // return view('jobs/edit', ["job" => $job]);
// });

// Edit with route binding
// Route::get('/jobs/{job}/edit', function (Job $job) {

//     // $job = Job::find($id); // using eloquent orm

//     return view('jobs/edit', ["job" => $job]);
// });

// Edit with controller
Route::get('/jobs/{job}/edit', [JobController::class, "edit"]);


// Show
// Route::get('/jobs/{id}', function ($id) {

//     $job = Job::find($id); // using eloquent orm

//     return view('jobs/show', ["job" => $job]);
// });

// Show but with route binding where the dynamic part is not the id column (which is default) but say a column called slug
// Route::get('/posts/{post:slug}', function (Post $post) {

//     return view('poasts/show', ["job" => $post]);
// });

// Show but with route binding
// Route::get('/jobs/{job}', function (Job $job) {

//     return view('jobs/show', ["job" => $job]);
// });

// Show with controller
Route::get('/jobs/{job}', [JobController::class, "show"]);



// Store
// Route::post('/jobs', function () {

//     // validation akin to zod of js fame
//     request()->validate([
//         'title' => ['required', 'min:3'],
//         'salary' => ['required']
//     ]);


//     // recall that all of these fields must be in the fillable property of the model to allow record creation like this.
//     // This fillable feature can be disabled.
//     Job::create([
//         "title" => request('title'),
//         "salary" => request('salary'),
//         "employer_id" => 1
//     ]);

//     return redirect('/jobs');
// });

// Store with controller
Route::post('/jobs', [JobController::class, "store"]);

// Update
// Route::patch('/jobs/{job}', function (Job $job) {

//     // validation
//     request()->validate([
//         'title' => ['required', 'min:3'],
//         'salary' => ['required']
//     ]);

//     // Authorize
//     // TODO:

//     // using eloquent orm. If Id not found findOrFail issues an abort 
//     // that will bubble up the stack and result in an appropriate error 
//     // as determined by laraval
//     // $job = Job::findOrFail($id); // using eloquent orm

//     // Update
//     // $job->title = request('title');
//     // $job->salary = request('salary');
//     // $job->save();

//     // OR alternatively

//     $job->update([
//         'title' => request('title'),
//         'salary' => request('salary')
//     ]);

//     return redirect('/jobs/' . $job['id']);
// });

// Update with controller
Route::patch('/jobs/{job}', [JobController::class, "update"]);


// Destroy
// Route::delete('/jobs/{job}', function (Job $job) {

//     // Authorize
//     // TODO:

//     // If Id not found findOrFail issues an abort 
//     // that will bubble up the stack and result in an appropriate error 
//     // as determined by laraval
//     // $job = Job::findOrFail($id); // using eloquent orm.

//     // Delete
//     $job->delete();

//     return redirect('/jobs');
// });

// Destroy with controller
Route::delete('/jobs/{job}', [JobController::class, "destroy"]);

Route::get('/contact', function () {
    return view('contact');
});
// Route::view('/contact', 'contact');
