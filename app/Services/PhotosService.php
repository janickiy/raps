<?php

namespace App\Services;


use App\Models\Photos;
use App\Http\Traits\File;
use Illuminate\Http\Request;
use Image;
use Storage;
use Exception;

class PhotosService
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

        if ($request->file('image')->move('uploads/' . Photos::getTableName(), $fileNameToStore) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        $img = Image::make(Storage::disk('public')->path(Photos::getTableName() . '/' . $fileNameToStore));
        $img->resize(300, 600, function ($constraint) {
            $constraint->aspectRatio();
        });

        if ($img->save(Storage::disk('public')->path(Photos::getTableName() . '/' . $thumbnailFileNameToStore)) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        return $filename;
    }

    /**
     * @param Request $request
     * @param Photos $photo
     * @return string
     * @throws Exception
     */
    public function updateImage(Request $request, Photos $photo): string
    {
        File::deleteFile($photo->thumbnail, Photos::getTableName());
        File::deleteFile($photo->origin, Photos::getTableName());

        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $fileNameToStore = 'origin_' . $filename;
        $thumbnailFileNameToStore = 'thumbnail_' . $filename;

        if ($request->file('image')->move('uploads/' . Photos::getTableName(), $fileNameToStore) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }
        $img = Image::make(Storage::disk('public')->path(Photos::getTableName() . '/' . $fileNameToStore));
        $img->resize(null, 600, function ($constraint) {
            $constraint->aspectRatio();
        });

        if ($img->save(Storage::disk('public')->path('images/' . $thumbnailFileNameToStore)) === false) {
            throw new Exception('Не удалось сохранить фото!');
        }

        return $filename;
    }
}
