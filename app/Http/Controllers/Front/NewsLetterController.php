<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Front\SubscribeNewsletterRequest;
use App\Models\NewsletterSubscriber;

class NewsLetterController extends Controller
{
    public function subscribe(SubscribeNewsletterRequest $request)
    {
        NewsletterSubscriber::create($request->validated());

        return response()->json([
            'message' => 'Thank you for subscribing to our newsletter!',
        ]);
    }
}
