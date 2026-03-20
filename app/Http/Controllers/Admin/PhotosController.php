<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Photos\DeleteRequest;
use App\Http\Requests\Admin\Photos\EditRequest;
use App\Http\Requests\Admin\Photos\UploadRequest;
use App\Http\Traits\File;
use App\Models\Photos;
use App\Repositories\PhotoAlbumRepository;
use App\Repositories\PhotosRepository;
use App\Services\PhotosService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PhotosController extends Controller
{
    use File;

    /**
     * @param PhotosRepository $photosRepository
     * @param PhotoAlbumRepository $photoAlbumRepository
     * @param PhotosService $photosService
     */
    public function __construct(
        private readonly PhotosRepository $photosRepository,
        private readonly PhotoAlbumRepository $photoAlbumRepository,
        private readonly PhotosService $photosService
    ) {
        parent::__construct();
    }

    /**
     * @param int $photoalbum_id
     * @return View
     */
    public function index(int $photoalbum_id): View
    {
        $row = $this->findAlbumOrFail($photoalbum_id);

        return view('cp.photos.index', [
            'row' => $row,
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'title' => 'Фото: ' . $row->title,
        ]);
    }

    /**
     * @param UploadRequest $request
     * @return RedirectResponse
     */
    public function upload(UploadRequest $request): RedirectResponse
    {
        $photoAlbumId = $request->integer('photoalbum_id');

        try {
            $this->findAlbumOrFail($photoAlbumId);

            $image = $this->photosService->storeImage($request);

            $this->photosRepository->create(array_merge($request->all(), [
                'thumbnail' => 'thumbnail_' . $image,
                'origin' => 'origin_' . $image,
            ]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('cp.photos.index', ['photoalbum_id' => $photoAlbumId])
            ->with('success', 'Данные успешно добавлены');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->findPhotoOrFail($id);

        return view('cp.photos.create_edit', [
            'row' => $row,
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'title' => 'Редактирование фото',
        ]);
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $id = $request->integer('id');

        try {
            $row = $this->findPhotoOrFail($id);

            $data = $request->all();

            $pic = $request->input('pic');

            if ($pic !== null) {
                File::deleteFile($row->thumbnail, Photos::getTableName());
                File::deleteFile($row->origin, Photos::getTableName());

                $data['thumbnail'] = null;
                $data['origin'] = null;
            }

            if ($request->hasFile('image')) {
                $image = $this->photosService->updateImage($request, $row);

                $data['thumbnail'] = 'thumbnail_' . $image;
                $data['origin'] = 'origin_' . $image;
            }

            $updated = $this->photosRepository->update($id, $data);

            if (!$updated) {
                abort(404);
            }
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('cp.photos.index', ['photoalbum_id' => $row->photoalbum_id])
            ->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $id = $request->integer('id');

        $this->findPhotoOrFail($id);

        $this->photosRepository->remove($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function findAlbumOrFail(int $id): mixed
    {
        $row = $this->photoAlbumRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return $row;
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function findPhotoOrFail(int $id): mixed
    {
        $row = $this->photosRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return $row;
    }
}
