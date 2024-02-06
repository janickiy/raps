<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pages;
use App\Models\Products;
use App\Models\Services;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::query()->count();
        $pages = Pages::query()->count();
        $services = Services::query()->count();
        $products = Products::query()->count();

        return view('cp.dashboard.index', compact('users', 'pages', 'services', 'products'))->with('title', 'Главная');
    }
}
