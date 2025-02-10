<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Service\FileService;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
        $this->middleware('auth:api');
    }

    public function apply(Request $request, Job $job)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Create job application
        $application = $job->applications()->create([
            'user_id' => auth()->id(),
            'status'  => 'pending'
        ]);

        // Store the file
        $file = $this->fileService->store(
            $request->file('resume'),
            auth()->id(),
            $application->id
        );

        return response()->json([
            'message'     => 'Application submitted successfully',
            'application' => $application,
            'file'        => $file
        ]);
    }
}