<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            return DataTables::of(User::query())->make(true);
        }
        return view('users.index');
    }
}
