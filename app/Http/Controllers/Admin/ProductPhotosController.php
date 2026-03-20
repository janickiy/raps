<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use App\Http\Requests\Admin\ProductPhotos\DeleteRequest;
use App\Http\Requests\Admin\ProductPhotos\EditRequest;
use App\Http\Requests\Admin\ProductPhotos\UploadRequest;
use App\Repositories\ProductPhotosRepository;
use App\Services\ProductPhotosService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductPhotosController extends Controller
{
    public function __construct(
        private readonly ProductPhotosRepository $productPhotosRepository,
        private readonly ProductPhotosService $productPhotosService,
    ) {
        parent::__construct();
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $row = $this->findOrFail($product_id);

        return view('cp.product_photos.index', [
            'row' => $row,
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'title' => 'Фото оборудования: ' . $row->title,
        ]);
    }

    /**
     * @param UploadRequest $request
     * @return RedirectResponse
     */
    public function upload(UploadRequest $request): RedirectResponse
    {
        $productId = $request->integer('product_id');

        try {
            $image = $this->productPhotosService->storeImage($request);

            $this->productPhotosRepository->create(array_merge(
                $request->all(),
                [
                    'origin' => 'origin_' . $image,
                    'thumbnail' => 'thumbnail_' . $image,
                ]
            ));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('cp.product_photos.index', ['product_id' => $productId])
            ->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->findOrFail($id);

        return view('cp.product_photos.create_edit', [
            'row' => $row,
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'title' => 'Редактирование фото: ' . $row->product->title,
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
            $productPhoto = $this->findOrFail($id);

            $data = $request->all();

            if ($request->hasFile('image')) {
                $image = $this->productPhotosService->updateImage($request, $productPhoto);

                $data['origin'] = 'origin_' . $image;
                $data['thumbnail'] = 'thumbnail_' . $image;
            }

            $updated = $this->productPhotosRepository->update($id, $data);

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
            ->route('cp.product_photos.index', ['product_id' => $productPhoto->product_id])
            ->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $id = $request->integer('id');

        $this->findOrFail($id);

        $this->productPhotosRepository->remove($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function findOrFail(int $id): mixed
    {
        $row = $this->productPhotosRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return $row;
    }
}
