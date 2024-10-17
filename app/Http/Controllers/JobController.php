<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{

    public function index()
    {
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
    }

    public function create()
    {
        return view('jobs/create');
    }

    public function show(Job $job)
    {
        return view('jobs/show', ["job" => $job]);
    }

    public function store()
    {
        // validation akin to zod of js fame
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);


        // recall that all of these fields must be in the fillable property of the model to allow record creation like this.
        // This fillable feature can be disabled.
        Job::create([
            "title" => request('title'),
            "salary" => request('salary'),
            "employer_id" => 1
        ]);

        return redirect('/jobs');
    }

    public function edit(Job $job)
    {
        return view('jobs/edit', ["job" => $job]);
    }

    public function update(Job $job)
    {
        // validation
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        // Authorize
        // TODO:

        // using eloquent orm. If Id not found findOrFail issues an abort 
        // that will bubble up the stack and result in an appropriate error 
        // as determined by laraval
        // $job = Job::findOrFail($id); // using eloquent orm

        // Update
        // $job->title = request('title');
        // $job->salary = request('salary');
        // $job->save();

        // OR alternatively

        $job->update([
            'title' => request('title'),
            'salary' => request('salary')
        ]);

        return redirect('/jobs/' . $job['id']);
    }

    public function destroy(Job $job)
    {
        // Authorize
        // TODO:

        // If Id not found findOrFail issues an abort 
        // that will bubble up the stack and result in an appropriate error 
        // as determined by laraval
        // $job = Job::findOrFail($id); // using eloquent orm.

        // Delete
        $job->delete();

        return redirect('/jobs');
    }
}
