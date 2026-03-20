<?php

namespace App\Services;

use App\Http\Traits\File;
use App\Models\Pages;
use Exception;
use Illuminate\Http\Request;
use Image;
use Storage;

class PageService
{
    use File;

    /**
     * @throws Exception
     */
    public function storeImage(Request $request): string
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time();
        $originName = $filename . '.' . $extension;

        if ($request->file('image')->move('uploads/' . Pages::getTableName(), $originName) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        $img = Image::make(Storage::disk('public')->path(Pages::getTableName() . '/' . $originName));
        $img->resize(null, 700, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(Storage::disk('public')->path(Pages::getTableName() . '/' . '2x_' . $filename . '.' . $extension));

        $smallImg = Image::make(Storage::disk('public')->path(Pages::getTableName() . '/' . $originName));
        $smallImg->resize(null, 350, function ($constraint) {
            $constraint->aspectRatio();
        });

        if ($smallImg->save(Storage::disk('public')->path(Pages::getTableName() . '/' . $originName)) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        return $originName;
    }

    /**
     * @throws Exception
     */
    public function updateImage(Request $request, Pages $page): string
    {
        if ($page->image !== null) {
            File::deleteFile($page->image, Pages::getTableName());
            File::deleteFile('2x_' . $page->image, Pages::getTableName());
        }

        return $this->storeImage($request);
    }
}
