<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Photoalbum, Photos};
use App\Helpers\StringHelper;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Photos\EditRequest;
use App\Http\Requests\Admin\Photos\UploadRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Storage;
use Image;

class PhotosController extends Controller
{

    /**
     * @param int $photoalbum_id
     * @return View
     */
    public function index(int $photoalbum_id): View
    {
        $row = Photoalbum::find($photoalbum_id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.photos.index', compact('row', 'maxUploadFileSize'))->with('title', 'Фото: ' . $row->title);
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
                $img->resize(300, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });

                if ($img->save(Storage::disk('public')->path('images/' . $thumbnailFileNameToStore))) {
                    Photos::create(array_merge(array_merge($request->all()), [
                        'thumbnail' => $thumbnailFileNameToStore ?? null,
                        'origin' => $fileNameToStore ?? null,
                    ]));

                    return redirect()->route('cp.photos.index', ['photoalbum_id' => $request->photoalbum_id])->with('success', 'Данные успешно обновлены');
                }
            }
        }

        return redirect()->route('cp.photos.index', ['photoalbum_id' => $request->photoalbum_id])->with('error', 'Ошибка добавления фото');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Photos::find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.photos.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование фото: ' . $row->product->title);
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = Photos::find($request->id);

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
                $img->resize(null, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });

                if ($img->save(Storage::disk('public')->path('images/' . $thumbnailFileNameToStore))) {
                    $row->thumbnail = $thumbnailFileNameToStore;
                    $row->origin = $fileNameToStore;
                }
            }
        }

        $row->title = $request->input('title');
        $row->description = $request->input('description');
        $row->alt = $request->input('alt');
        $row->save();

        return redirect()->route('cp.photos.index', ['photoalbum_id' => $row->photoalbum_id])->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        Photos::find($request->id)->remove();
    }
}
