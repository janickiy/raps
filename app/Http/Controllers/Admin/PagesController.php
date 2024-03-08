<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use Illuminate\Http\Request;
use App\Models\{Pages};
use Validator;
use Storage;
use Image;
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

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.pages.create_edit', compact('options', 'maxUploadFileSize'))->with('title', 'Добавление раздела');
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
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
            'slug' => 'required|unique:pages',
            'main' => 'integer|nullable'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time();
            $originName = $filename . '.' . $extension;

            if ($request->file('image')->move('uploads/pages', $originName)) {

                $img = Image::make(Storage::disk('public')->path('pages/' . $originName));
                $img->resize(null, 700, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(Storage::disk('public')->path('pages/' . '2x_' . $filename . '.' . $extension));

                $small_img = Image::make(Storage::disk('public')->path('pages/' . $originName));

                $small_img->resize(null, 350, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $small_img->save(Storage::disk('public')->path('pages/' . $originName));

            }
        }

        Pages::create(array_merge(array_merge($request->all()), [
            'image' => $originName ?? null,
        ]));

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

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.pages.create_edit', compact('row', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование раздела');

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
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
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

        if ($request->hasFile('image')) {

            $image = $request->pic;

            if ($image != null) {
                if (Storage::disk('public')->exists('pages/' . $row->image) === true) Storage::disk('public')->delete('pages/' . $row->image);
                if (Storage::disk('public')->exists('pages/' . '2x_' . $row->image) === true) Storage::disk('public')->delete('pages/' . '2x_' . $row->image);
            }

            if ($request->hasFile('image')) {

                if (Storage::disk('public')->exists('pages/' . $row->image) === true) Storage::disk('public')->delete('pages/' . $row->image);
                if (Storage::disk('public')->exists('pages/' . '2x_' . $row->image) === true) Storage::disk('public')->delete('pages/' . '2x_' . $row->image);

                $extension = $request->file('image')->getClientOriginalExtension();
                $filename = time();
                $originName = $filename . '.' . $extension;

                if ($request->file('image')->move('uploads/pages', $originName)) {
                    $img = Image::make(Storage::disk('public')->path('pages/' . $originName));
                    $img->resize(null, 700, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save(Storage::disk('public')->path('pages/' . '2x_' . $filename . '.' . $extension));

                    $small_img = Image::make(Storage::disk('public')->path('pages/' . $originName));

                    $small_img->resize(null, 350, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    if ($small_img->save(Storage::disk('public')->path('pages/' . $originName))) $row->image = $originName;
                }
            }
        }

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
        Pages:find($request->id)->remove();
    }
}
