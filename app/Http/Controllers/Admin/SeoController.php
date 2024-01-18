<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Seo;
use URL;


class SeoController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('cp.seo.index')->with('title', 'Seo');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $row = Seo::find($id);

        if (!$row) abort(404);

        return view('cp.seo.edit', compact('row'))->with('title', 'Редактирование seo');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
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
