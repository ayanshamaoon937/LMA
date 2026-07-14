<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\SubmitJobApplicationRequest;
use App\Services\JobApplicationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JobController extends Controller
{
    protected JobApplicationService $jobApplicationService;

    public function __construct(JobApplicationService $jobApplicationService)
    {
        $this->jobApplicationService = $jobApplicationService;
    }

    /**
     * Handle temporary CV upload from FilePond.
     */
    public function uploadCv(Request $request): Response|JsonResponse
    {
        try {
            $request->validate([
                'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // Max 5MB
            ]);

            if ($request->hasFile('cv')) {
                $cv = $this->jobApplicationService->storeTempCv($request->file('cv'));
                // Return the record ID as plain text for FilePond
                return response($cv->id, 200)
                    ->header('Content-Type', 'text/plain');
            }

            return response()->json(['message' => 'No file uploaded.'], 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred during upload.'], 500);
        }
    }

    /**
     * Handle reverting temporary CV upload from FilePond.
     */
    public function revertCv(Request $request): Response|JsonResponse
    {
        try {
            // FilePond sends the server ID in the request body
            $cvId = (int) $request->getContent() ?: (int) $request->input('cv');

            if ($cvId > 0) {
                $success = $this->jobApplicationService->revertCv($cvId);
                if ($success) {
                    return response('Reverted successfully', 200)
                        ->header('Content-Type', 'text/plain');
                }
            }

            return response()->json(['message' => 'File not found or already processed.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred during revert.'], 500);
        }
    }

    /**
     * Submit job application form.
     */
    public function apply(SubmitJobApplicationRequest $request): JsonResponse
    {
        try {
            $application = $this->jobApplicationService->submitApplication($request->validated());

            return response()->json([
                'message' => 'Your application has been submitted successfully!',
                'application_id' => $application->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while submitting your application. Please try again.',
            ], 500);
        }
    }
}
