<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ProductParameters\DeleteRequest;
use App\Http\Requests\Admin\ProductParameters\EditRequest;
use App\Http\Requests\Admin\ProductParameters\StoreRequest;
use App\Repositories\ProductParametersRepository;
use App\Repositories\ProductsRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductParametersController extends Controller
{
    /**
     * @param ProductParametersRepository $productParametersRepository
     * @param ProductsRepository $productsRepository
     */
    public function __construct(
        private readonly ProductParametersRepository $productParametersRepository,
        private readonly ProductsRepository $productsRepository
    ) {
        parent::__construct();
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $product = $this->findProductOrFail($product_id);

        $breadcrumbs = [
            ['url' => route('cp.products.index'), 'title' => 'Продукция'],
        ];

        return view('cp.product_parameters.index', [
            'product_id' => $product_id,
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Технические характеристики: ' . $product->title,
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
            ['url' => route('cp.product_parameters.index', ['product_id' => $product_id]), 'title' => $row->title],
        ];

        return view('cp.product_parameters.create_edit', [
            'product_id' => $product_id,
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Добавление параметра',
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

            $this->productParametersRepository->create(
                $this->prepareData($request->all())
            );
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('cp.product_parameters.index', ['product_id' => $productId])
            ->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->findParameterOrFail($id);
        $product_id = $row->product_id;

        $breadcrumbs = [
            ['url' => route('cp.products.index'), 'title' => 'Продукция'],
            ['url' => route('cp.product_parameters.index', ['product_id' => $product_id]), 'title' => $row->product->title],
        ];

        return view('cp.product_parameters.create_edit', [
            'row' => $row,
            'product_id' => $product_id,
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Редактирование параметра',
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
            $row = $this->findParameterOrFail($id);

            $updated = $this->productParametersRepository->update(
                $id,
                $this->prepareData($request->all())
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
            ->route('cp.product_parameters.index', ['product_id' => $row->product_id])
            ->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $id = $request->integer('id');

        $this->findParameterOrFail($id);

        $this->productParametersRepository->delete($id);
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
    private function findParameterOrFail(int $id): mixed
    {
        $row = $this->productParametersRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return $row;
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareData(array $data): array
    {
        $data['category_id'] = !empty($data['category_id']) ? (int) $data['category_id'] : 0;

        return $data;
    }
}
