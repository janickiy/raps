<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use App\Models\Pages;
use Illuminate\Http\Request;
use App\Http\Request\Admin\Pages\StoreRequest;
use App\Http\Request\Admin\Pages\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Storage;
use Image;
use URL;

class PagesController extends Controller
{

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.pages.index')->with('title', 'Страницы и разделы');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $options = [];

        foreach (Pages::orderBy('id')->published()->get() as $page) {
            $options[$page->id] = $page->title;
        }

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.pages.create_edit', compact('options', 'maxUploadFileSize'))->with('title', 'Добавление раздела');
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

        $published = 0;

        if ($request->input('published')) {
            $published = 1;
        }

        Pages::create(array_merge(array_merge($request->all()), [
            'image' => $originName ?? null,
            'published' => $published,
        ]));

        return redirect(URL::route('cp.pages.index'))->with('success', 'Данные успешно добавлены');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Pages::find($id);

        if (!$row) abort(404);

        $options = [];

        foreach (Pages::orderBy('id')->published()->get() as $page) {
            $options[$page->id] = $page->title;
        }

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.pages.create_edit', compact('row', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование раздела');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
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
     * @return void
     */
    public function destroy(Request $request): void
    {
        Pages::find($request->id)->remove();
    }
}
