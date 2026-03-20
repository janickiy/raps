<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ProductSoft\DeleteRequest;
use App\Http\Requests\Admin\ProductSoft\EditRequest;
use App\Http\Requests\Admin\ProductSoft\StoreRequest;
use App\Repositories\ProductSoftRepository;
use App\Repositories\ProductsRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductSoftController extends Controller
{
    /**
     * @param ProductSoftRepository $productSoftRepository
     * @param ProductsRepository $productsRepository
     */
    public function __construct(
        private readonly ProductSoftRepository $productSoftRepository,
        private readonly ProductsRepository $productsRepository,
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

        return view('cp.product_soft.index', [
            'product_id' => $product_id,
            'title' => 'Список программного обеспечения: ' . $row->title,
        ]);
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function create(int $product_id): View
    {
        $this->findProductOrFail($product_id);

        return view('cp.product_soft.create_edit', [
            'product_id' => $product_id,
            'title' => 'Добавление программного обеспечения',
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

            $this->productSoftRepository->create($request->all());
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('cp.product_soft.index', ['product_id' => $productId])
            ->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->findSoftOrFail($id);

        return view('cp.product_soft.create_edit', [
            'row' => $row,
            'product_id' => $row->product_id,
            'title' => 'Редактирование списка программного обеспечения',
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
            $row = $this->findSoftOrFail($id);

            $updated = $this->productSoftRepository->update($id, $request->all());

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
            ->route('cp.product_soft.index', ['product_id' => $row->product_id])
            ->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $id = $request->integer('id');

        $this->findSoftOrFail($id);

        $this->productSoftRepository->delete($id);
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
    private function findSoftOrFail(int $id): mixed
    {
        $row = $this->productSoftRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return $row;
    }
}
