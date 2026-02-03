<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use App\Http\Requests\Admin\ProductPhotos\EditRequest;
use App\Http\Requests\Admin\ProductPhotos\UploadRequest;
use App\Models\{ProductPhotos};
use App\Repositories\ProductPhotosRepository;
use App\Services\ProductPhotosService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductPhotosController extends Controller
{
    public function __construct(
        private ProductPhotosRepository $productPhotosRepository,
        private ProductPhotosService $productPhotosService
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
            if ($request->hasFile('image')) {
                $image = $this->productPhotosService->storeImage($request);
                $fileNameToStore = 'origin_' . $image;
                $thumbnailFileNameToStore = 'thumbnail_' . $image;
            }

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

        $row = $this->productPhotosRepository->find($request->id);

        if ($request->hasFile('file')) {
            $filename = $this->productPhotosService->updateImage($row->id, $row);
        }

        $this->productDocumentsRepository->update($request->id, array_merge(array_merge($request->all()), [
            'file' => $filename ?? null,
        ]));





        $row = ProductPhotos::find($request->id);

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
                $img->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                if ($img->save(Storage::disk('public')->path('images/' . $thumbnailFileNameToStore))) {
                    $row->thumbnail = $thumbnailFileNameToStore;
                    $row->origin = $fileNameToStore;
                }
            }
        }

        $row->title = $request->input('title');
        $row->alt = $request->input('alt');

        $row->save();

        return redirect()->route('cp.product_photos.index', ['product_id' => $row->product_id])->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        ProductPhotos::find($request->id)->remove();
    }
}
