<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductParametersCategory;
use App\Http\Request\Admin\ProductParametersCategory\StoreRequest;
use App\Http\Request\Admin\ProductParametersCategory\EditRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Storage;

class ProductParametersCategoryController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.product_parameters_category.index')->with('title', 'Категории');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
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
        ProductParametersCategory::create($request->all());

        return redirect()->route('cp.product_parameters_category.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = ProductParametersCategory::find($id);

        if (!$row) abort(404);

        return view('cp.product_parameters_category.create_edit', compact('row'))->with('title', 'Редактирование категории');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = ProductParametersCategory::find($request->id);

        if (!$row) abort(404);

        $row->name = $request->input('name');
        $row->save();

        return redirect()->route('cp.product_parameters_category.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        ProductParametersCategory::find($request->id)->delete();
    }
}
