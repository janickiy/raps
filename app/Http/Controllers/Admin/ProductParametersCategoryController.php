<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ProductParametersCategory\DeleteRequest;
use App\Http\Requests\Admin\ProductParametersCategory\EditRequest;
use App\Http\Requests\Admin\ProductParametersCategory\StoreRequest;
use App\Repositories\ProductParametersCategoryRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductParametersCategoryController extends Controller
{
    public function __construct(
        private readonly ProductParametersCategoryRepository $productParametersCategoryRepository
    ) {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.product_parameters_category.index', [
            'title' => 'Категории',
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('cp.product_parameters_category.create_edit', [
            'title' => 'Добавление категории',
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $this->productParametersCategoryRepository->create(
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
            ->route('cp.product_parameters_category.index')
            ->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('cp.product_parameters_category.create_edit', [
            'row' => $this->findOrFail($id),
            'title' => 'Редактирование категории',
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
            $this->findOrFail($id);

            $updated = $this->productParametersCategoryRepository->update(
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
            ->route('cp.product_parameters_category.index')
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

        $this->productParametersCategoryRepository->delete($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function findOrFail(int $id): mixed
    {
        $row = $this->productParametersCategoryRepository->find($id);

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
