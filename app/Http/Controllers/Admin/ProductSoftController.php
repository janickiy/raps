<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ProductSoftRepository;
use App\Repositories\ProductsRepository;
use App\Http\Requests\Admin\ProductSoft\StoreRequest;
use App\Http\Requests\Admin\ProductSoft\EditRequest;
use App\Http\Requests\Admin\ProductSoft\DeleteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class ProductSoftController extends Controller
{
    public function __construct(
        private ProductSoftRepository $productSoftRepository,
        private ProductsRepository $productsRepository,
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
        $row = $this->productsRepository->find($product_id);

        if (!$row) abort(404);

        return view('cp.product_soft.index', compact('product_id'))->with('title', 'Список программного обеспечения: ' . $row->title);
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function create(int $product_id): View
    {
        return view('cp.product_soft.create_edit', compact('product_id'))->with('title', 'Добавление программного обеспечения');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $this->productSoftRepository->create($request->all());
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.product_soft.index', ['product_id' => $request->product_id])->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->productSoftRepository->find($id);

        if (!$row) abort(404);

        $product_id = $row->product_id;

        return view('cp.product_soft.create_edit', compact('row', 'product_id'))->with('title', 'Редактирование списка программного обеспечения');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $row = $this->productSoftRepository->find($request->id);
            $this->productSoftRepository->update($request->id, $request->all());
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.product_soft.index', ['product_id' => $row->product_id])->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->productSoftRepository->delete($request->id);
    }
}
