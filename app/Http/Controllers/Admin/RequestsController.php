<?php

namespace App\Http\Controllers\Admin;


class RequestsController extends Controller
{
    public function index()
    {
        return view('cp.requests.index')->with('title', 'Заявки');
    }
}
