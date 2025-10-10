<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Http\Request\Admin\Services\StoreRequest;
use App\Http\Request\Admin\Services\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Image;
use Storage;

class ServicesController extends Controller
{

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.services.index')->with('title', 'Услуги');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.services.create_edit', compact('maxUploadFileSize'))->with('title', 'Добавление услугу');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
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

        $published = 0;

        if ($request->input('published')) {
            $published = 1;
        }

        $seo_sitemap = 0;

        if ($request->input('seo_sitemap')) {
            $seo_sitemap = 1;
        }

        Services::create(array_merge(array_merge($request->all()), [
            'image' => $originName ?? null,
            'published' => $published,
            'seo_sitemap' => $seo_sitemap,
        ]));

        return redirect()->route('cp.services.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Services::find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.services.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование услуги');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
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

        $published = 0;

        if ($request->input('published')) {
            $published = 1;
        }

        $row->published = $published;
        $seo_sitemap = 0;

        if ($request->input('seo_sitemap')) {
            $seo_sitemap = 1;
        }

        $row->seo_sitemap = $seo_sitemap;
        $row->save();

        return redirect()->route('cp.services.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request): Void
    {
        Services::find($request->id)->remove();
    }
}
