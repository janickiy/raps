<?php

namespace App\Services;

use App\Http\Traits\File;
use App\Models\ProductPhotos;
use Illuminate\Http\Request;
use Image;
use Storage;
use Exception;

class ProductPhotosService
{
    use File;

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

        if ( $img->save(Storage::disk('public')->path('products/' . $thumbnailFileNameToStore)) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        return $filename;
    }

    /**
     * @param Request $request
     * @param ProductPhotos $productPhoto
     * @return string
     * @throws Exception
     */
    public function updateImage(Request $request, ProductPhotos $productPhoto): string
    {
        $image = $request->pic;

        if ($image !== null) {
            File::getFile($productPhoto->thumbnail, ProductPhotos::getTableName());
            File::deleteFile($productPhoto->origin, ProductPhotos::getTableName());
        }

        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $fileNameToStore = 'origin_' . $filename;
        $thumbnailFileNameToStore = 'thumbnail_' . $filename;

        if ($request->file('image')->move('uploads/' . ProductPhotos::getTableName(), $fileNameToStore) === true) {
            File::getFile($productPhoto->thumbnail, ProductPhotos::getTableName());
            File::deleteFile($productPhoto->origin, ProductPhotos::getTableName());

            $img = Image::make(Storage::disk('public')->path('images/' . $fileNameToStore));
            $img->resize(null, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            if ($img->save(Storage::disk('public')->path(ProductPhotos::getTableName() . '/' . $thumbnailFileNameToStore)) === false) {
                throw new Exception('Не удалось сохранить фото!');
            }
        } else {
            throw new Exception('Не удалось сохранить фото!');
        }

        return $filename;
    }
}
