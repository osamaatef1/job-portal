<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('admin')->only(['store', 'update', 'destroy']);
    }

    public function store(JobRequest $request)
    {
        $job = Job::create($request->validated());
        return response()->json($job, 201);
    }

    public function apply(Job $job)
    {
        $application = $job->applications()->create([
            'user_id' => auth()->id(),
            'status' => 'pending'
        ]);

        broadcast(new JobApplicationSubmitted($application))->toOthers();

        return response()->json(['message' => 'Application submitted successfully']);
    }
}
