<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use App\Models\Services;
use Illuminate\Http\Request;
use URL;
use Validator;
use Image;
use Storage;

class ServicesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('cp.services.index')->with('title', 'Продукция');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.services.create_edit', compact('maxUploadFileSize'))->with('title', 'Добавление продукции');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'full_description' => 'required',
            'slug' => 'required|unique:services',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048|nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time();
            $originName = $filename . '.' . $extension;

            if ($request->file('image')->move('uploads/services', $originName)) {

                $img = Image::make(Storage::disk('public')->path('services/' . $originName));
                $img->resize(null, 700, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(Storage::disk('public')->path('services/' . '2x_' . $filename . '.' . $extension));

                $small_img = Image::make(Storage::disk('public')->path('services/' . $originName));

                $small_img->resize(null, 350, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $small_img->save(Storage::disk('public')->path('services/' . $originName));

            }
        }

        Services::create(array_merge(array_merge($request->all()), [
            'thumbnail' => $thumbnailFileNameToStore ?? null,
            'origin' => $fileNameToStore ?? null,
        ]));

        return redirect(URL::route('cp.services.index'))->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $row = Services::find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.services.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование продукции');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'full_description' => 'required',
            'slug' => 'required|unique:services,slug,' . $request->id,
            'image' => 'image|mimes:jpeg,jpg,png|max:2048|nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $row = Services::find($request->id);

        if (!$row) abort(404);

        $row->title = $request->input('title');
        $row->description = $request->input('description');
        $row->full_description = $request->input('full_description');
        $row->meta_title = $request->input('meta_title');
        $row->meta_description = $request->input('meta_description');
        $row->meta_keywords = $request->input('meta_keywords');
        $row->slug = $request->input('slug');
        $row->seo_h1 = $request->input('seo_h1');
        $row->seo_url_canonical = $request->input('seo_url_canonical');

        if ($request->hasFile('image')) {

            $image = $request->pic;

            if ($image != null) {
                if (Storage::disk('public')->exists('services/' . $row->image) === true) Storage::disk('public')->delete('services/' . $row->image);
                if (Storage::disk('public')->exists('services/' . '2x_' . $row->image) === true) Storage::disk('public')->delete('services/' . '2x_' . $row->image);
            }

            if ($request->hasFile('image')) {

                if (Storage::disk('public')->exists('services/' . $row->image) === true) Storage::disk('public')->delete('services/' . $row->image);
                if (Storage::disk('public')->exists('services/' . '2x_' . $row->image) === true) Storage::disk('public')->delete('services/' . '2x_' . $row->image);

                $extension = $request->file('image')->getClientOriginalExtension();
                $filename = time();
                $originName = $filename . '.' . $extension;

                if ($request->file('image')->move('uploads/services', $originName)) {
                    $img = Image::make(Storage::disk('public')->path('services/' . $originName));
                    $img->resize(null, 700, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save(Storage::disk('public')->path('services/' . '2x_' . $filename . '.' . $extension));

                    $small_img = Image::make(Storage::disk('public')->path('services/' . $originName));

                    $small_img->resize(null, 350, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    if ($small_img->save(Storage::disk('public')->path('services/' . $originName))) $row->image = $originName;
                }
            }
        }

        $row->image_title = $request->input('image_title');
        $row->image_alt = $request->input('image_alt');

        $row->save();

        return redirect(URL::route('cp.services.index'))->with('success', 'Данные обновлены');

    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        Services::find($request->id)->remove();
    }
}
