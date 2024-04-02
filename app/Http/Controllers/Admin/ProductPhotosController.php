<?php

namespace App\Http\Controllers\Admin;

use App\Models\{
    ProductPhotos,
    Products
};
use App\Helpers\StringHelper;
use Illuminate\Http\Request;
use App\Http\Request\Admin\ProductPhotos\EditRequest;
use App\Http\Request\Admin\ProductPhotos\UploadRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Storage;
use Image;
use URL;

class ProductPhotosController extends Controller
{

    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $row = Products::find($product_id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.product_photos.index', compact('row', 'maxUploadFileSize'))->with('title', 'Фото оборудования: ' . $row->title);
    }

    /**
     * @param UploadRequest $request
     * @return RedirectResponse
     */
    public function upload(UploadRequest $request): RedirectResponse
    {
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $fileNameToStore = 'origin_' . $filename;
            $thumbnailFileNameToStore = 'thumbnail_' . $filename;

            if ($request->file('image')->move('uploads/images', $fileNameToStore)) {
                $img = Image::make(Storage::disk('public')->path('images/' . $fileNameToStore));
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                if ($img->save(Storage::disk('public')->path('images/' . $thumbnailFileNameToStore))) {
                    ProductPhotos::create(array_merge(array_merge($request->all()), [
                        'thumbnail' => $thumbnailFileNameToStore ?? null,
                        'origin' => $fileNameToStore ?? null,
                    ]));

                    return redirect(URL::route('cp.product_photos.index', ['product_id' => $request->product_id]))->with('success', 'Данные успешно обновлены');
                }
            }
        }

        return redirect(URL::route('cp.product_photos.index', ['product_id' => $request->product_id]))->with('error', 'Ошибка добавления фото');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = ProductPhotos::find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.product_photos.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование фото: ' . $row->product->title);

    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = ProductPhotos::find($request->id);

        if (!$row) abort(404);

        if ($request->hasFile('image')) {

            $image = $request->pic;

            if ($image != null) {
                if (Storage::disk('public')->exists('images/' . $row->thumbnail) === true) Storage::disk('public')->delete('images/' . $row->thumbnail);
                if (Storage::disk('public')->exists('images/' . $row->origin) === true) Storage::disk('public')->delete('images/' . $row->origin);
            }

            if (Storage::disk('public')->exists('images/' . $row->thumbnail) === true) Storage::disk('public')->delete('images/' . $row->thumbnail);
            if (Storage::disk('public')->exists('images/' . $row->origin) === true) Storage::disk('public')->delete('images/' . $row->origin);;

            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $fileNameToStore = 'origin_' . $filename;
            $thumbnailFileNameToStore = 'thumbnail_' . $filename;

            if ($request->file('image')->move('uploads/images', $fileNameToStore)) {
                $img = Image::make(Storage::disk('public')->path('images/' . $fileNameToStore));
                $img->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                if ($img->save(Storage::disk('public')->path('images/' . $thumbnailFileNameToStore))) {
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
     * @return void
     */
    public function destroy(Request $request): void
    {
        ProductPhotos::find($request->id)->remove();
    }
}
