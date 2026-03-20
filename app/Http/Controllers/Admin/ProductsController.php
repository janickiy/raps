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
    /**
     * @param ProductsRepository $productsRepository
     * @param ProductsService $productsService
     * @param CatalogRepository $catalogRepository
     */
    public function __construct(
        private readonly ProductsRepository $productsRepository,
        private readonly ProductsService $productsService,
        private readonly CatalogRepository $catalogRepository
    ) {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.products.index', [
            'title' => 'Продукция',
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('cp.products.create_edit', [
            'options' => $this->catalogRepository->getOptions(),
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'title' => 'Добавление продукции',
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            [$thumbnail, $origin] = $this->prepareImageData($request);

            $this->productsRepository->createFromDto(
                ProductData::fromRequest($request, $thumbnail, $origin)
            );
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('cp.products.index')
            ->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('cp.products.create_edit', [
            'row' => $this->findOrFail($id),
            'options' => $this->catalogRepository->getOptions(),
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'title' => 'Редактирование продукции',
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
            $product = $this->findOrFail($id);
            [$thumbnail, $origin] = $this->prepareImageData($request, $product);

            $updated = $this->productsRepository->updateFromDto(
                $id,
                ProductData::fromRequest($request, $thumbnail, $origin)
            );

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
            ->route('cp.products.index')
            ->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $id = $request->integer('id');

        $this->findOrFail($id);

        $this->productsRepository->remove($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function findOrFail(int $id): mixed
    {
        $row = $this->productsRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return $row;
    }

    /**
     * @param StoreRequest|EditRequest $request
     * @param mixed|null $product
     * @return null[]|string[]
     * @throws Exception
     */
    private function prepareImageData(StoreRequest|EditRequest $request, mixed $product = null): array
    {
        if (!$request->hasFile('image')) {
            return [null, null];
        }

        $filename = $product
            ? $this->productsService->updateImage($request, $product)
            : $this->productsService->storeImage($request);

        return [
            'thumbnail_' . $filename,
            'origin_' . $filename,
        ];
    }
}
