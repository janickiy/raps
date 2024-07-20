<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Seo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use URL;

class SeoController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.seo.index')->with('title', 'Seo');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Seo::find($id);

        if (!$row) abort(404);

        return view('cp.seo.edit', compact('row'))->with('title', 'Редактирование seo');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $row = Seo::find($request->id);

        if (!$row) abort(404);

        $row->h1 = $request->input('h1');
        $row->title = $request->input('title');
        $row->keyword = $request->input('keyword');
        $row->description = $request->input('description');
        $row->url_canonical = $request->input('url_canonical');

        $row->save();

        return redirect(URL::route('cp.seo.index'))->with('success', 'Данные успешно обновлены');
    }
}
