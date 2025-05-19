<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function form()
    {
        return view('send-email'); // Blade: resources/views/send-email.blade.php
    }

    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        Mail::raw('Ini adalah email percobaan dari Laravel.', function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Percobaan Email dari Laravel');
        });

        return back()->with('success', 'Email berhasil dikirim!');
    }
}

