<?php

namespace App\Services;

use App\Http\Traits\File;
use App\Models\Products;
use Exception;
use Illuminate\Http\Request;
use Image;
use Storage;

class ProductsService
{
    use File;

    /**
     * @throws Exception
     */
    public function storeImage(Request $request): string
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $fileNameToStore = 'origin_' . $filename;
        $thumbnailFileNameToStore = 'thumbnail_' . $filename;

        if ($request->file('image')->move('uploads/' . Products::getTableName(), $fileNameToStore) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        $img = Image::make(Storage::disk('public')->path(Products::getTableName() . '/' . $fileNameToStore));
        $img->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
        });

        if ($img->save(Storage::disk('public')->path(Products::getTableName() . '/' . $thumbnailFileNameToStore)) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        return $filename;
    }

    /**
     * @throws Exception
     */
    public function updateImage(Request $request, Products $product): string
    {
        if ($product->thumbnail !== null) {
            File::deleteFile($product->thumbnail, Products::getTableName());
        }

        if ($product->origin !== null) {
            File::deleteFile($product->origin, Products::getTableName());
        }

        return $this->storeImage($request);
    }
}
