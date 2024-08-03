<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductParametersCategory;
use App\Models\ProductParameters;
use App\Http\Request\Admin\ProductParameters\StoreRequest;
use App\Http\Request\Admin\ProductParameters\EditRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductParametersController extends Controller
{
    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $parameters = ProductParameters::where('product_id', $product_id)->get();

        if (!$parameters) abort(404);

        return view('cp.product_parameters.index', compact('parameters', 'product_id'))->with('title', 'Технические характеристики');
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function create(int $product_id): View
    {
        $options = ProductParametersCategory::getOption();

        return view('cp.product_parameters.create_edit', compact('product_id', 'options'))->with('title', 'Добавление параметра');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        ProductParameters::create(array_merge($request->all(), ['category_id' => $request->category_id ?? 0]));

        return redirect()->route('cp.product_parameters.index', ['product_id' => $request->product_id])->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = ProductParameters::find($id);

        if (!$row) abort(404);

        $options = ProductParametersCategory::getOption();
        $product_id = $row->product_id;

        return view('cp.product_parameters.create_edit', compact('row', 'product_id', 'options'))->with('title', 'Редактирование параметра');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = ProductParameters::find($request->id);

        if (!$row) abort(404);

        $row->name = $request->input('name');
        $row->value = $request->input('value');
        $row->category_id = $request->category_id ?? 0;
        $row->save();

        return redirect()->route('cp.product_parameters.index', ['product_id' => $row->product_id])->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        ProductParameters::where('id', $request->id)->delete();
    }
}
