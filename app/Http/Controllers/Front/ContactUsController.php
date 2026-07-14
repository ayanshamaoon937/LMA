<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\GoogleRecaptcha;
use App\Services\CmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminContactMail;

use Illuminate\Support\Facades\RateLimiter;

use Illuminate\Validation\ValidationException;

class ContactUsController extends Controller
{
    public function __construct(private readonly CmsService $cms) {}

    private function sections(string $slug): array
    {
        return $this->cms->allSections($slug);
    }

    public function index(Request $request)
    {
        return view('front.pages.contact-us', [
            'cms'       => $this->sections('contact-us'),
            'recaptcha' => GoogleRecaptcha::first(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|min:10|max:5000',
        ]);
        // dd($request->input('g-recaptcha-response'));

        $key = 'contact-us:' . $request->ip();
      
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'message' => "Too many attempts. Please try again in {$seconds} seconds.",
                'errors'  => ['message' => ["Too many attempts. Please try again in {$seconds} seconds."]],
            ], 422);
        }
        RateLimiter::hit($key, 60); 


        // reCAPTCHA verification
        $recaptcha = GoogleRecaptcha::first();
        if ($recaptcha && $recaptcha->enable) {
            $token = $request->input('g-recaptcha-response');

            if (!$token) {
                return response()->json([
                    'message' => 'Please complete the reCAPTCHA verification.',
                    'errors'  => ['g-recaptcha-response' => ['Please complete the reCAPTCHA verification.']],
                ], 422);
            }

            $verify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $recaptcha->secret_key,
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);

            if (! $verify->json('success')) {
                return response()->json([
                    'message' => 'reCAPTCHA verification failed. Please try again.',
                    'errors'  => ['g-recaptcha-response' => ['reCAPTCHA verification failed. Please try again.']],
                ], 422);
            }
        }

        ContactMessage::create([
            // 'name'       => $request->name,
            'email'      => $request->email,
            'message'    => $request->message,
            'ip_address' => $request->ip(),
        ]);

        // Notify admin
        try {
            $adminEmail = get_setting('email')
                       ?? config('mail.from.address');

            if ($adminEmail) {
                Mail::to($adminEmail)->queue(new AdminContactMail(
                    // $request->name,
                    $request->email,
                    $request->message,
                    null    
                ));
            }
        } catch (\Exception $e) {
            Log::error('Contact mail notification failed: ' . $e->getMessage());
        }

        return response()->json([
            'message' => "Thank you, {$request->name}! Your message has been sent. We'll get back to you soon.",
        ]);
    }
}
