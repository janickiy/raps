<?php

namespace App\Services;

use App\Models\Products;
use Illuminate\Http\Request;
use Image;
use Storage;
use Exception;

class ProductsService
{
    /**
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function storeImage(Request $request): string
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $fileNameToStore = 'origin_' . $filename;
        $thumbnailFileNameToStore = 'thumbnail_' . $filename;

        if ($request->file('image')->move('uploads/products', $fileNameToStore) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        $img = Image::make(Storage::disk('public')->path('products/' . $fileNameToStore));
        $img->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(Storage::disk('public')->path('products/' . $thumbnailFileNameToStore));

        return $filename;
    }

    /**
     * @param Request $request
     * @param Products $product
     * @return string
     * @throws Exception
     */
    public function updateImage(Request $request, Products $product): string
    {
        $image = $request->pic;

        if ($image != null) {
            if (Storage::disk('public')->exists('products/' . $product->thumbnail) === true) Storage::disk('public')->delete('products/' . $product->thumbnail);
            if (Storage::disk('public')->exists('products/' . $product->origin) === true) Storage::disk('public')->delete('products/' . $product->origin);
        }

        if (Storage::disk('public')->exists('products/' . $product->thumbnail) === true) Storage::disk('public')->delete('products/' . $product->thumbnail);
        if (Storage::disk('public')->exists('products/' . $product->origin) === true) Storage::disk('public')->delete('products/' . $product->origin);;

        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $fileNameToStore = 'origin_' . $filename;
        $thumbnailFileNameToStore = 'thumbnail_' . $filename;

        if ($request->file('image')->move('uploads/products', $fileNameToStore) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }
        $img = Image::make(Storage::disk('public')->path('products/' . $fileNameToStore));
        $img->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
        });

        if ($img->save(Storage::disk('public')->path('products/' . $thumbnailFileNameToStore))) {
            $product->thumbnail = $thumbnailFileNameToStore;
            $product->origin = $fileNameToStore;
        }

        return $filename;
    }
}
