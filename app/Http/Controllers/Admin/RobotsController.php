<?php

namespace App\Http\Controllers\Admin;

use App\Http\Request\Admin\Robots\UpdateRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RobotsController extends Controller
{
    /**
     * @return View
     */
    public function edit(): View
    {
        $file = File::get(public_path('robots.txt'));

        return view('cp.robots.edit', compact('file'))->with('title', 'Редактирование Robots.txt');
    }

    /**
     * @param UpdateRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request): RedirectResponse
    {
        File::put(public_path('robots.txt'), $request->input('content'));

        return redirect()->route('cp.robots.edit')->with('success', 'Данные успешно обновлены');
    }
}
