<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use Illuminate\Http\Request;
use App\Models\Catalog;
use Validator;
use Storage;
use Image;
use URL;

class CatalogController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('cp.catalog.index')->with('title', 'Категории');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.catalog.create_edit', compact('maxUploadFileSize'))->with('title', 'Добавление категории');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048|nullable',
            'slug' => 'required|unique:catalog',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time();
            $originName = $filename . '.' . $extension;

            if ($request->file('image')->move('uploads/catalog', $originName)) {

                $img = Image::make(Storage::disk('public')->path('catalog/' . $originName));
                $img->resize(null, 700, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(Storage::disk('public')->path('catalog/' . '2x_' . $filename . '.' . $extension));

                $small_img = Image::make(Storage::disk('public')->path('catalog/' . $originName));

                $small_img->resize(null, 350, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $small_img->save(Storage::disk('public')->path('catalog/' . $originName));

            }
        }

        Catalog::create(array_merge(array_merge($request->all()), [
            'image' => $originName ?? null,
        ]));

        return redirect(URL::route('cp.catalog.index'))->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $row = Catalog::find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.catalog.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование категории');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048|nullable',
            'slug' => 'required|unique:catalog,slug,' . $request->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $row = Catalog::find($request->id);

        if (!$row) abort(404);

        $row->name = $request->input('name');
        $row->description = $request->input('description');
        $row->slug = $request->input('slug');
        $row->meta_title = $request->input('meta_title');
        $row->meta_description = $request->input('meta_description');
        $row->meta_keywords = $request->input('meta_keywords');
        $row->seo_h1 = $request->input('seo_h1');
        $row->seo_url_canonical = $request->input('seo_url_canonical');

        if ($request->hasFile('image')) {

            $image = $request->pic;

            if ($image != null) {
                if (Storage::disk('public')->exists('catalog/' . $row->image) === true) Storage::disk('public')->delete('catalog/' . $row->image);
                if (Storage::disk('public')->exists('catalog/' . '2x_' . $row->image) === true) Storage::disk('public')->delete('catalog/' . '2x_' . $row->image);
            }

            if ($request->hasFile('image')) {

                if (Storage::disk('public')->exists('catalog/' . $row->image) === true) Storage::disk('public')->delete('catalog/' . $row->image);
                if (Storage::disk('public')->exists('catalog/' . '2x_' . $row->image) === true) Storage::disk('public')->delete('catalog/' . '2x_' . $row->image);

                $extension = $request->file('image')->getClientOriginalExtension();
                $filename = time();
                $originName = $filename . '.' . $extension;

                if ($request->file('image')->move('uploads/catalog', $originName)) {
                    $img = Image::make(Storage::disk('public')->path('catalog/' . $originName));
                    $img->resize(null, 700, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save(Storage::disk('public')->path('catalog/' . '2x_' . $filename . '.' . $extension));

                    $small_img = Image::make(Storage::disk('public')->path('catalog/' . $originName));

                    $small_img->resize(null, 350, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    if ($small_img->save(Storage::disk('public')->path('catalog/' . $originName))) $row->image = $originName;
                }
            }
        }

        $row->image_title = $request->input('image_title');
        $row->image_alt = $request->input('image_alt');

        $row->save();

        return redirect(URL::route('cp.catalog.index'))->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        Catalog::find($request->id)->remove();
    }

}
