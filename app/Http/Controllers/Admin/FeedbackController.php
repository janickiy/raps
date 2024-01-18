<?php

namespace App\Http\Controllers\Admin;


class FeedbackController extends Controller
{
    public function index()
    {
        return view('cp.feedback.index')->with('title', 'Сообщения с сайта');
    }

}
