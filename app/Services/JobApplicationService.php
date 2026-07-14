<?php

namespace App\Services;

use App\Models\JobApplication;
use App\Models\JobApplicationCv;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JobApplicationService
{
    /**
     * Store a temporary CV upload.
     */
    public function storeTempCv(UploadedFile $file): JobApplicationCv
    {
        $filename = $file->getClientOriginalName();
        $mimeType = $file->getClientMimeType();
        $fileSize = $file->getSize();

        // Generate a unique filename to prevent conflicts
        $safeName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $tempPath = $file->storeAs('cvs/temp', $safeName, 'public');

        return JobApplicationCv::create([
            'filename' => $filename,
            'file_path' => $tempPath,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
            'is_temp' => true,
        ]);
    }

    /**
     * Revert a temporary CV upload.
     */
    public function revertCv(int $cvId): bool
    {
        $cv = JobApplicationCv::where('id', $cvId)->where('is_temp', true)->first();

        if ($cv) {
            if (Storage::disk('public')->exists($cv->file_path)) {
                Storage::disk('public')->delete($cv->file_path);
            }
            return (bool) $cv->delete();
        }

        return false;
    }

    /**
     * Save the job application and make the CV permanent.
     */
    public function submitApplication(array $data): JobApplication
    {
        $cv = JobApplicationCv::findOrFail($data['cv']);

        // Move the file from temp to permanent storage
        $tempPath = $cv->file_path;
        if (Storage::disk('public')->exists($tempPath)) {
            $permanentPath = str_replace('cvs/temp/', 'cvs_applications/', $tempPath);
            
            Storage::disk('public')->move($tempPath, $permanentPath);
            
            // Update the CV record
            $cv->update([
                'file_path' => $permanentPath,
                'is_temp' => false,
            ]);
        }

        // Create the job application
        return JobApplication::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'position' => $data['position'],
            'cover_letter' => $data['cover_letter'] ?? null,
            'job_application_cv_id' => $cv->id,
        ]);
    }
}
