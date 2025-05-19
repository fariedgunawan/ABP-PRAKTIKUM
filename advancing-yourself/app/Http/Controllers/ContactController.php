<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function create() {
        return view('contact');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);
        return back()->with('success', 'Form submitted!');
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        Mail::to($request->email)->send(new ContactMail($request->name, $request->email));

        return back()->with('success', 'Email sent!');
    }
}
