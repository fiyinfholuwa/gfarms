<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        try {
            // Validate form fields
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:50',
                'subject' => 'nullable|string|max:255',
                'message' => 'nullable|string|max:5000',
            ]);
            ContactMessage::create($validator->validated());
            return GeneralController::sendNotification('', 'success', '', 'Thank you for contacting us! We’ll get back to you soon.');
        } catch (\Exception $e) {
            return GeneralController::sendNotification('', 'error', '', 'Something went wrong, please try again later.'.$e->getMessage());
        }
    }

}
