<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Catalog, Products};
use App\Helpers\StringHelper;
use URL;
use Validator;
use Image;
use Storage;

class ProductsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('cp.products.index')->with('title', 'Продукция');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $options = Catalog::getOption();

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.products.create_edit', compact('options', 'maxUploadFileSize'))->with('title', 'Добавление продукции');
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
            'slug' => 'required|unique:products',
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
            'catalog_id' => 'integer|required|exists:catalog,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

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

        return redirect(URL::route('cp.products.index'))->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $row = Products::find($id);

        if (!$row) abort(404);

        $options = Catalog::getOption();

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.products.create_edit', compact('row', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование продукции');

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
            'slug' => 'required|unique:products,slug,' . $request->id,
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
            'price' => 'nullable|integer',
            'catalog_id' => 'integer|required|exists:catalog,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

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

        $row->image_title = $request->input('image_title');
        $row->image_alt = $request->input('image_alt');
        $row->save();

        return redirect(URL::route('cp.products.index'))->with('success', 'Данные обновлены');

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
