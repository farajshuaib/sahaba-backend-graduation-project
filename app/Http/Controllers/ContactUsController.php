<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactEmailRequest;
use App\Mail\contactUs;
use Exception;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function index()
    {

    }

    public function sendEmail(ContactEmailRequest $request)
    {

        try {
            Mail::send(new contactUs($request->validated()));
            return response()->json(['message' => 'mail sent successfully'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }


    }
}
