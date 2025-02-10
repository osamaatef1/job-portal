<?php

namespace App\Service;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function store(UploadedFile $file, $userId, $jobApplicationId = null)
    {
        $path = $file->store('applications', 'public');

        return File::create([
            'user_id'            => $userId,
            'job_application_id' => $jobApplicationId,
            'filename'           => basename($path),
            'original_name'      => $file->getClientOriginalName(),
            'path'               => $path,
            'mime_type'          => $file->getMimeType(),
            'expires_at'         => Carbon::now()->addDays(30) // Files expire after 30 days
        ]);
    }

    public function deleteExpired()
    {
        $expiredFiles = File::where('expires_at', '<', Carbon::now())->get();

        foreach ($expiredFiles as $file) {
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }
    }
}