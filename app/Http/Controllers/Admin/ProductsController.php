<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Catalog, Products};
use App\Helpers\StringHelper;
use App\Http\Request\Admin\Products\StoreRequest;
use App\Http\Request\Admin\Products\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use URL;
use Image;
use Storage;

class ProductsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.products.index')->with('title', 'Продукция');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $options = Catalog::getOption();

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.products.create_edit', compact('options', 'maxUploadFileSize'))->with('title', 'Добавление продукции');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $fileNameToStore = 'origin_' . $filename;
            $thumbnailFileNameToStore = 'thumbnail_' . $filename;

            if ($request->file('image')->move('uploads/products', $fileNameToStore)) {
                $img = Image::make(Storage::disk('public')->path('products/' . $fileNameToStore));
                $img->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(Storage::disk('public')->path('products/' . $thumbnailFileNameToStore) );
            }
        }

        Products::create(array_merge(array_merge($request->all()), [
            'thumbnail' => $thumbnailFileNameToStore ?? null,
            'origin' => $fileNameToStore ?? null,
        ]));

        return redirect()->route('cp.products.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Products::find($id);

        if (!$row) abort(404);

        $options = Catalog::getOption();

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.products.create_edit', compact('row', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование продукции');

    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = Products::find($request->id);

        if (!$row) abort(404);

        $row->title = $request->input('title');
        $row->description = $request->input('description');
        $row->full_description = $request->input('full_description');
        $row->catalog_id = $request->catalog_id;
        $row->price = $request->input('price');
        $row->explosion_protection = $request->input('explosion_protection');
        $row->gases = $request->input('gases');
        $row->dust_protection = $request->input('dust_protection');
        $row->meta_title = $request->input('meta_title');
        $row->meta_description = $request->input('meta_description');
        $row->meta_keywords = $request->input('meta_keywords');
        $row->slug = $request->input('slug');
        $row->seo_h1 = $request->input('seo_h1');
        $row->seo_url_canonical = $request->input('seo_url_canonical');

        if ($request->hasFile('image')) {
            $image = $request->pic;

            if ($image != null) {
                if (Storage::disk('public')->exists('products/' . $row->thumbnail) === true) Storage::disk('public')->delete('products/' . $row->thumbnail);
                if (Storage::disk('public')->exists('products/' . $row->origin) === true) Storage::disk('public')->delete('products/' . $row->origin);
            }

            if (Storage::disk('public')->exists('products/' . $row->thumbnail) === true) Storage::disk('public')->delete('products/' . $row->thumbnail);
            if (Storage::disk('public')->exists('products/' . $row->origin) === true) Storage::disk('public')->delete('products/' . $row->origin);;

            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $fileNameToStore = 'origin_' . $filename;
            $thumbnailFileNameToStore = 'thumbnail_' . $filename;

            if ($request->file('image')->move('uploads/products', $fileNameToStore)) {
                $img = Image::make(Storage::disk('public')->path('products/' . $fileNameToStore ));
                $img->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                if ($img->save(Storage::disk('public')->path('products/'  . $thumbnailFileNameToStore) )) {
                    $row->thumbnail = $thumbnailFileNameToStore;
                    $row->origin = $fileNameToStore;
                }
            }
        }

        $published = 0;

        if ($request->input('published')) {
            $published = 1;
        }

        $row->published = $published;

        $row->image_title = $request->input('image_title');
        $row->image_alt = $request->input('image_alt');
        $row->save();

        return redirect()->route('cp.products.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        Products::find($request->id)->remove();
    }
}
