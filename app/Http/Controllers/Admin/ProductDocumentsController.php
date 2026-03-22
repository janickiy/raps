<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use App\Http\Requests\Admin\ProductDocuments\DeleteRequest;
use App\Http\Requests\Admin\ProductDocuments\EditRequest;
use App\Http\Requests\Admin\ProductDocuments\StoreRequest;
use App\Repositories\ProductDocumentsRepository;
use App\Repositories\ProductsRepository;
use App\Services\ProductDocumentsService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductDocumentsController extends Controller
{
    /**
     * @param ProductDocumentsRepository $productDocumentsRepository
     * @param ProductsRepository $productsRepository
     * @param ProductDocumentsService $productDocumentsService
     */
    public function __construct(
        private readonly ProductDocumentsRepository $productDocumentsRepository,
        private readonly ProductsRepository $productsRepository,
        private readonly ProductDocumentsService $productDocumentsService
    ) {
        parent::__construct();
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $row = $this->findProductOrFail($product_id);

        $breadcrumbs = [
            ['url' => route('cp.products.index'), 'title' => 'Продукция'],
        ];

        return view('cp.product_documents.index', [
            'product_id' => $product_id,
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Список документации: ' . $row->title,
        ]);
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function create(int $product_id): View
    {
        $row = $this->findProductOrFail($product_id);

        $breadcrumbs = [
            ['url' => route('cp.products.index'), 'title' => 'Продукция'],
            ['url' => route('cp.product_documents.index', ['product_id' => $product_id]), 'title' => $row->title],
        ];

        return view('cp.product_documents.create_edit', [
            'product_id' => $product_id,
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Добавление документации',
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $productId = $request->integer('product_id');

        try {
            $this->findProductOrFail($productId);

            $filename = $this->productDocumentsService->storeFile($request);

            $this->productDocumentsRepository->create(array_merge(
                $request->all(),
                ['path' => $filename]
            ));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('cp.product_documents.index', ['product_id' => $productId])
            ->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->findDocumentOrFail($id);
        $product_id = $row->product_id;

        $breadcrumbs = [
            ['url' => route('cp.products.index'), 'title' => 'Продукция'],
            ['url' => route('cp.product_documents.index', ['product_id' => $row->product_id]), 'title' => $row->product->title],
        ];

        return view('cp.product_documents.create_edit', [
            'row' => $row,
            'product_id' => $product_id,
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Редактирование списка документации',
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
            $row = $this->findDocumentOrFail($id);

            $data = $request->all();

            if ($request->hasFile('file')) {
                $data['path'] = $this->productDocumentsService->updateFile($row, $request);
            }

            $updated = $this->productDocumentsRepository->update($id, $data);

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
            ->route('cp.product_documents.index', ['product_id' => $row->product_id])
            ->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $id = $request->integer('id');

        $this->findDocumentOrFail($id);

        $this->productDocumentsRepository->remove($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function findProductOrFail(int $id): mixed
    {
        $row = $this->productsRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return $row;
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function findDocumentOrFail(int $id): mixed
    {
        $row = $this->productDocumentsRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return $row;
    }
}
