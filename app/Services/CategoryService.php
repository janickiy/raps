<?php

namespace App\Services;


use App\Http\Traits\File;
use App\Models\Catalog;
use Illuminate\Http\Request;
use Image;
use Storage;
use Exception;

class CategoryService
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
        $filename = time();
        $originName = $filename . '.' . $extension;

        if ($request->file('image')->move('uploads/' . Catalog::getTableName(), $originName) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        $img = Image::make(Storage::disk('public')->path(Catalog::getTableName() . '/' . $originName));
        $img->resize(null, 700, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(Storage::disk('public')->path(Catalog::getTableName() . '/' . '2x_' . $filename . '.' . $extension));
        $small_img = Image::make(Storage::disk('public')->path(Catalog::getTableName() . '/' . $originName));

        $small_img->resize(null, 350, function ($constraint) {
            $constraint->aspectRatio();
        });

        if ($small_img->save(Storage::disk('public')->path(Catalog::getTableName() . '/' . $originName)) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        return $originName;
    }

    /**
     * @param Request $request
     * @param Catalog $catalog
     * @return string
     * @throws Exception
     */
    public function updateImage(Request $request, Catalog $catalog): string
    {
        File::deleteFile($catalog->image, Catalog::getTableName());
        File::deleteFile('2x_' . $catalog->image, Catalog::getTableName());

        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time();
        $originName = $filename . '.' . $extension;

        if ($request->file('image')->move('uploads/' . Catalog::getTableName(), $originName) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        $img = Image::make(Storage::disk('public')->path(Catalog::getTableName() . '/' . $originName));
        $img->resize(null, 700, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(Storage::disk('public')->path(Catalog::getTableName() . '/' . '2x_' . $filename . '.' . $extension));

        $small_img = Image::make(Storage::disk('public')->path(Catalog::getTableName() . '/' . $originName));

        $small_img->resize(null, 350, function ($constraint) {
            $constraint->aspectRatio();
        });

        if ($small_img->save(Storage::disk('public')->path(Catalog::getTableName() . '/' . $originName)) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        return $originName;
    }
}
