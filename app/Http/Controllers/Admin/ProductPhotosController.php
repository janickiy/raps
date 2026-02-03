<?php

namespace App\Http\Controllers\Admin;


use App\Helpers\StringHelper;
use App\Http\Requests\Admin\ProductPhotos\EditRequest;
use App\Http\Requests\Admin\ProductPhotos\UploadRequest;
use App\Http\Requests\Admin\ProductPhotos\DeleteRequest;
use App\Repositories\ProductPhotosRepository;
use App\Services\ProductPhotosService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class ProductPhotosController extends Controller
{
    /**
     * @param ProductPhotosRepository $productPhotosRepository
     * @param ProductPhotosService $productPhotosService
     */
    public function __construct(
        private ProductPhotosRepository $productPhotosRepository,
        private ProductPhotosService    $productPhotosService,
    )
    {
        parent::__construct();
    }


    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $row = $this->productPhotosRepository->find($product_id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.product_photos.index', compact('row', 'maxUploadFileSize'))->with('title', 'Фото оборудования: ' . $row->title);
    }

    /**
     * @param UploadRequest $request
     * @return RedirectResponse
     */
    public function upload(UploadRequest $request): RedirectResponse
    {
        try {
            $image = $this->productPhotosService->storeImage($request);
            $fileNameToStore = 'origin_' . $image;
            $thumbnailFileNameToStore = 'thumbnail_' . $image;

            $this->productPhotosRepository->create(array_merge($request->all(), ['origin' => $fileNameToStore, 'thumbnail' => $thumbnailFileNameToStore]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.product_photos.index', ['product_id' => $request->product_id])->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->productPhotosRepository->find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.product_photos.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование фото: ' . $row->product->title);
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $productPhoto = $this->productPhotosRepository->find($request->id);

            if ($request->hasFile('image')) {
                $image = $this->productPhotosService->updateImage($request, $productPhoto);
                $fileNameToStore = 'origin_' . $image;
                $thumbnailFileNameToStore = 'thumbnail_' . $image;
            }

            $this->productPhotosRepository->update($request->id, array_merge(array_merge($request->all()), [
                'origin' => $fileNameToStore ?? null,
                'thumbnail' => $thumbnailFileNameToStore ?? null
            ]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.product_photos.index', ['product_id' => $productPhoto->product_id])->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->productPhotosRepository->remove($request->id);
    }
}
