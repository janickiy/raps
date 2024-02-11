<?php

namespace App\Http\Controllers\Admin;

use App\Models\Products;
use App\Models\Requests;
use App\Models\Services;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::query()->count();
        $requests = Requests::query()->count();
        $services = Services::query()->count();
        $products = Products::query()->count();

        return view('cp.dashboard.index', compact('users', 'requests', 'services', 'products'))->with('title', 'Главная');
    }
}
