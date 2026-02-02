<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\ProductParametersCategory\StoreRequest;
use App\Http\Requests\Admin\ProductParametersCategory\EditRequest;
use App\Http\Requests\Admin\ProductParametersCategory\DeleteRequest;
use App\Repositories\ProductParametersCategoryRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;


class ProductParametersCategoryController extends Controller
{
    public function __construct(
        private ProductParametersCategoryRepository $productParametersCategoryRepository)
    {
        parent::__construct();
    }


    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.product_parameters_category.index')->with('title', 'Категории');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('cp.product_parameters_category.create_edit')->with('title', 'Добавление категории');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->productParametersCategoryRepository->create($request->all());

        return redirect()->route('cp.product_parameters_category.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row =$this->productParametersCategoryRepository->find($id);

        if (!$row) abort(404);

        return view('cp.product_parameters_category.create_edit', compact('row'))->with('title', 'Редактирование категории');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $this->productParametersCategoryRepository->update($request->id, array_merge($request->all(), ['category_id' => $request->category_id ?? 0]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.product_parameters_category.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->productParametersCategoryRepository->delete($request->id);
    }
}
