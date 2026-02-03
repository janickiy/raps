<?php

namespace App\Services;


use App\Http\Traits\File;
use App\Models\Services;
use Illuminate\Http\Request;
use Image;
use Storage;
use Exception;

class ServicesService
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

        if ($request->file('image')->move('uploads/' . Services::getTableName(), $originName) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        $img = Image::make(Storage::disk('public')->path(Services::getTableName() . '/' . $originName));
        $img->resize(null, 700, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->save(Storage::disk('public')->path(Services::getTableName() . '/' . '2x_' . $filename . '.' . $extension));
        $small_img = Image::make(Storage::disk('public')->path(Services::getTableName() . '/' . $originName));
        $small_img->resize(null, 350, function ($constraint) {
            $constraint->aspectRatio();
        });

        if ($small_img->save(Storage::disk('public')->path(Services::getTableName() . '/' . $originName)) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        return $originName;
    }

    /**
     * @param Request $request
     * @param Services $services
     * @return string
     * @throws Exception
     */
    public function updateImage(Request $request, Services $services): string
    {
        $image = $request->pic;

        if ($image !== null) {
            File::deleteFile($services->image, Services::getTableName());
            File::deleteFile('2x_' . $services->image, Services::getTableName());
        }

        if ($request->hasFile('image')) {
            File::deleteFile($services->image, Services::getTableName());
            File::deleteFile('2x_' . $services->image, Services::getTableName());

            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time();
            $originName = $filename . '.' . $extension;

            if ($request->file('image')->move('uploads/' . Services::getTableName(), $originName) === false) {
                throw new Exception('Не удалось сохранить фото!');
            }
            $img = Image::make(Storage::disk('public')->path(Services::getTableName() . '/' . $originName));
            $img->resize(null, 700, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(Storage::disk('public')->path(Services::getTableName() . '/' . '2x_' . $filename . '.' . $extension));

            $small_img = Image::make(Storage::disk('public')->path('services/' . $originName));
            $small_img->resize(null, 350, function ($constraint) {
                $constraint->aspectRatio();
            });

            if ($small_img->save(Storage::disk('public')->path('services/' . $originName)) === false) {
                throw new Exception('Не удалось сохранить фото!');
            }

        }

        return $originName;
    }
}
