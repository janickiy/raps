<?php

namespace App\Http\Controllers\Admin;

use App\Models\{
    ProductPhotos,
    Products
};
use App\Helpers\StringHelper;
use Illuminate\Http\Request;
use Validator;
use Storage;
use Image;
use URL;

class ProductPhotosController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param int $product_id
     * @return \Illuminate\Http\Response
     */
    public function index(int $product_id)
    {
        $row = Products::find($product_id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.product_photos.index', compact('row', 'maxUploadFileSize'))->with('title', 'Фото оборудования: ' . $row->title);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function upload(Request $request)
    {
        $rules = [
            'product_id' => 'required|integer|exists:products,id',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $fileNameToStore = 'origin_' . $filename;
        $thumbnailFileNameToStore = 'thumbnail_' . $filename;

        if ($request->file('image')->store('images', $fileNameToStore)) {
            $thumbnail = Image::make(Storage::disk('public')->path('/public/images/' . $fileNameToStore));
            $thumbnail->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            if ($thumbnail->save(Storage::disk('public')->path('/public/images/') . $thumbnailFileNameToStore)) {
                ProductPhotos::create(array_merge(array_merge($request->all()), [
                        'thumbnail' => $thumbnailFileNameToStore,
                        'origin' => $fileNameToStore
                    ]
                ));

                return redirect(URL::route('cp.product_photos.index', ['product_id' => $request->product_id]))->with('success', 'Данные успешно добавлены');
            }
        }

        return redirect(URL::route('cp.product_photos.index', ['product_id' => $request->product_id]))->with('error', 'Ошибка добавления фото');

    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $row = ProductPhotos::find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.product_photos.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование фото: ' . $row->product->title );

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $row = ProductPhotos::find($request->id);

        if (!$row) abort(404);

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists('images/' . $row->thumbnail) === true) Storage::disk('public')->delete('images/' . $row->thumbnail);
            if (Storage::disk('public')->exists('images/' . $row->origin) === true) Storage::disk('public')->delete('images/' . $row->origin);

            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $fileNameToStore = 'origin_' . $filename;
            $thumbnailFileNameToStore = 'thumbnail_' . $filename;

            if ($request->file('image')->store('public/images', $fileNameToStore)) {
                $img = Image::make(Storage::disk('public')->path('/public/images/' . $fileNameToStore));
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                if ($img->save(Storage::disk('public')->path('/public/images/' . $thumbnailFileNameToStore) )) {
                    $row->thumbnail = $thumbnailFileNameToStore;
                    $row->origin = $fileNameToStore;
                }
            }
        }

        $row->title = $request->input('title');
        $row->alt = $request->input('alt');

        $row->save();

        return redirect(URL::route('cp.product_photos.index', ['product_id' => $row->product_id]))->with('success', 'Данные успешно обновлены');

    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        $row = ProductPhotos::find($request->id);

        if ($row) {
            if (Storage::disk('public')->exists('images/' . $row->thumbnail) === true) Storage::disk('public')->delete('images/' . $row->thumbnail);
            if (Storage::disk('public')->exists('images/' . $row->origin) === true) Storage::disk('public')->delete('images/' . $row->origin);

            $row->delete();
        }

    }
}
