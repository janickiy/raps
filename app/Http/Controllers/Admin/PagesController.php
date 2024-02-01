<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Pages};
use Illuminate\Support\Facades\Validator;
use URL;

class PagesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('cp.pages.index')->with('title', 'Страницы и разделы');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $options = [];

        foreach (Pages::orderBy('id')->published()->get() as $row) {
            $options[$row->id] = $row->title;
        }

        return view('cp.pages.create_edit', compact('options'))->with('title', 'Добавление раздела');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'text' => 'required',
            'slug' => 'required|unique:pages',
            'main' => 'integer|nullable'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Pages::create($request->all());

        return redirect(URL::route('cp.pages.index'))->with('success', 'Данные успешно добавлены');

    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $row = Pages::find($id);

        if (!$row) abort(404);

        $options = [];

        foreach (Pages::orderBy('id')->published()->get() as $row) {
            $options[$row->id] = $row->title;
        }

        return view('cp.pages.create_edit', compact('row', 'options'))->with('title', 'Редактирование раздела');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'title' => 'required',
            'text' => 'required',
            'slug' => 'required|unique:pages,slug,' . $request->id,
            'main' => 'integer|nullable'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $row = Pages::find($request->id);

        if (!$row) abort(404);

        $row->title = $request->input('title');
        $row->text = $request->input('text');
        $row->meta_title = $request->input('meta_title');
        $row->meta_description = $request->input('meta_description');
        $row->meta_keywords = $request->input('meta_keywords');
        $row->slug = $request->input('slug');
        $row->seo_h1 = $request->input('seo_h1');
        $row->seo_url_canonical = $request->input('seo_url_canonical');

        $published = 0;

        if ($request->input('published')) {
            $published = 1;
        }

        $row->published = $published;

        $main = 0;

        if ($request->input('main')) {
            $main = 1;
            Pages::where('main', 1)->update(['main' => 0]);
        }

        $row->main = $main;
        $row->save();

        return redirect(URL::route('cp.pages.index'))->with('success', 'Данные успешно обновлены');

    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        Pages::where('id', $request->id)->delete();
    }
}
