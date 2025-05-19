<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function form() {
        return view('upload');
    }

    public function upload(Request $request) {
        $request->validate(['file' => 'required|file']);
        $path = $request->file('file')->store('public/files');
        return back()->with('success', 'File uploaded: ' . $path);
    }

}
