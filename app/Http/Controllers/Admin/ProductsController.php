<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Admin\ProductData;
use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Products\DeleteRequest;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Repositories\CatalogRepository;
use App\Repositories\ProductsRepository;
use App\Services\ProductsService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductsController extends Controller
{
    public function __construct(
        private ProductsRepository $productsRepository,
        private ProductsService $productsService,
        private CatalogRepository $catalogRepository
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.products.index')->with('title', 'Продукция');
    }

    public function create(): View
    {
        $options = $this->catalogRepository->getOptions();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.products.create_edit', compact('options', 'maxUploadFileSize'))->with('title', 'Добавление продукции');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $thumbnail = null;
            $origin = null;

            if ($request->hasFile('image')) {
                $filename = $this->productsService->storeImage($request);
                $origin = 'origin_' . $filename;
                $thumbnail = 'thumbnail_' . $filename;
            }

            $this->productsRepository->createFromDto(ProductData::fromRequest($request, $thumbnail, $origin));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.products.index')->with('success', 'Информация успешно добавлена');
    }

    public function edit(int $id): View
    {
        $row = $this->productsRepository->find($id);

        if (!$row) {
            abort(404);
        }

        $options = $this->catalogRepository->getOptions();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.products.create_edit', compact('row', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование продукции');
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $thumbnail = null;
            $origin = null;

            if ($request->hasFile('image')) {
                $product = $this->productsRepository->find($request->integer('id'));

                if (!$product) {
                    abort(404);
                }

                $filename = $this->productsService->updateImage($request, $product);
                $origin = 'origin_' . $filename;
                $thumbnail = 'thumbnail_' . $filename;
            }

            $this->productsRepository->updateFromDto(
                $request->integer('id'),
                ProductData::fromRequest($request, $thumbnail, $origin)
            );
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.products.index')->with('success', 'Данные обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->productsRepository->remove($request->integer('id'));
    }
}
