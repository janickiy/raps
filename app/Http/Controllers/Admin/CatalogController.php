<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Catalog;
use App\Http\Request\Admin\Catalog\{
    StoreRequest,
    EditRequest,
    DeleteRequest,
};
use Storage;
use Image;
use URL;

class CatalogController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $catalogs = Catalog::query()->orderBy('name')->get();
        $catalogsList = [];

        if ($catalogs) {
            foreach ($catalogs->toArray() as $catalog) {
                $catalogsList[$catalog['parent_id']][$catalog['id']] = $catalog;
            }
        }

        return view('cp.catalog.index', compact('catalogsList'))->with('title', 'Категории');
    }

    /**
     * @param int $parent_id
     * @return View
     */
    public function create(int $parent_id = 0): View
    {
        $options[0] = 'Выберите';
        $options = Catalog::ShowTree($options, 0);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.catalog.create_edit', compact('maxUploadFileSize', 'parent_id', 'options'))->with('title', 'Добавление категории');
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

        return redirect()->route('cp.catalog.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Catalog::find($id);

        if (!$row) abort(404);

        $options[0] = 'Выберите';

        Catalog::ShowTree($options, 0);

        $parent_id = $row->parent_id;
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        unset($options[$id]);

        return view('cp.catalog.create_edit', compact('row', 'parent_id', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование категории');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
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
        $row->parent_id = $request->input('parent_id');

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

        return redirect()->route('cp.catalog.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return RedirectResponse
     */
    public function destroy(DeleteRequest $request): RedirectResponse
    {
        Catalog::removeCatalogs($request->id);

        return  redirect()->route('cp.catalog.index')->with('success', 'Данные удалены');
    }
}
