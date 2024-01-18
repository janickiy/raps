<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pages;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::query()->count();
        $pages = Pages::query()->count();

        return view('cp.dashboard.index', compact('users', 'pages' ))->with('title', 'Главная');
    }
}
