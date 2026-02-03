<?php

namespace App\Http\Controllers\Admin;


use App\Http\Traits\File;
use App\Models\Photos;
use App\Repositories\PhotoAlbumRepository;
use App\Repositories\PhotosRepository;
use App\Services\PhotosService;
use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Photos\EditRequest;
use App\Http\Requests\Admin\Photos\UploadRequest;
use App\Http\Requests\Admin\Photos\DeleteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class PhotosController extends Controller
{
    use File;

    /**
     * @param PhotosRepository $photosRepository
     * @param PhotoAlbumRepository $photoAlbumRepository
     * @param PhotosService $photosService
     */
    public function __construct(
        private PhotosRepository     $photosRepository,
        private PhotoAlbumRepository $photoAlbumRepository,
        private PhotosService        $photosService
    )
    {
        parent::__construct();
    }

    /**
     * @param int $photoalbum_id
     * @return View
     */
    public function index(int $photoalbum_id): View
    {
        $row = $this->photoAlbumRepository->find($photoalbum_id);

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
        try {
            $image = $this->photosService->storeImage($request);
            $fileNameToStore = 'origin_' . $image;
            $thumbnailFileNameToStore = 'thumbnail_' . $image;
            $this->photosRepository->create(array_merge($request->all(), [
                'thumbnail' => $thumbnailFileNameToStore ?? null,
                'origin' => $fileNameToStore ?? null,
            ]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.photos.index', ['photoalbum_id' => $row->photoalbum_id])->with('success', 'Данные успешно добавлены');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->photosRepository->find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.photos.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование фото: ' . $row?->product->title);
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $row = $this->photosRepository->find($request->id);
            if (!$row) abort(404);

            $pic = $request->input('pic');

            if ($pic !== null) {
                File::deleteFile($row->thumbnail, Photos::getTableName());
                File::deleteFile($row->origin, Photos::getTableName());
            }

            if ($request->hasFile('image')) {
                $image = $this->photosService->updateImage($request, $row);
                $fileNameToStore = 'origin_' . $image;
                $thumbnailFileNameToStore = 'thumbnail_' . $image;
            }

            $this->photosRepository->update($request->id, array_merge($request->all(), [
                'thumbnail' => $thumbnailFileNameToStore ?? null,
                'origin' => $fileNameToStore ?? null,
            ]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.photos.index', ['photoalbum_id' => $row->photoalbum_id])->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->photosRepository->remove($request->id);
    }
}
