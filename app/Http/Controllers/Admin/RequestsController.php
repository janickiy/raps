<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;

class RequestsController extends Controller
{
    public function index(): View
    {
        return view('cp.requests.index')->with('title', 'Заявки');
    }
}
