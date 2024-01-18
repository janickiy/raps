<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use URL;

class RobotsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $file = File::get(public_path('robots.txt'));

        return view('cp.robots.edit', compact('file'))->with('title', 'Редактирование Robots.txt');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'content' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        File::put(public_path('robots.txt'), $request->input('content'));

        return redirect(URL::route('cp.robots.edit'))->with('success', 'Данные успешно обновлены');

    }

}
