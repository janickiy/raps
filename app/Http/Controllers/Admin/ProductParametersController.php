<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductParametersCategory;
use App\Models\ProductParameters;
use Illuminate\Http\Request;
use Validator;
use URL;

class ProductParametersController extends Controller
{

    /**
     * @param int $product_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(int $product_id)
    {
        $parameters = ProductParameters::where('product_id', $product_id)->get();

        if (!$parameters) abort(404);

        return view('cp.product_parameters.index', compact('parameters', 'product_id'))->with('title', 'Технические характеристики');
    }

    /**
     * @param int $product_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(int $product_id)
    {
        $options = ProductParametersCategory::getOption();

        return view('cp.product_parameters.create_edit', compact('product_id', 'options'))->with('title', 'Добавление параметра');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'value' => 'required',
            'product_id' => 'required|integer|exists:products,id',
            'category_id' => 'nullable|integer|exists:product_parameters_category,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        ProductParameters::create(array_merge($request->all(), ['category_id' => $request->category_id ?? 0]));

        return redirect(URL::route('cp.product_parameters.index', ['product_id' => $request->product_id]))->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $row = ProductParameters::find($id);

        if (!$row) abort(404);

        $options = ProductParametersCategory::getOption();

        $product_id = $row->product_id;

        return view('cp.product_parameters.create_edit', compact('row', 'product_id', 'options'))->with('title', 'Редактирование параметра');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
            'value' => 'required',
            'category_id' => 'nullable|integer|exists:product_parameters_category,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $row = ProductParameters::find($request->id);

        if (!$row) abort(404);

        $row->name = $request->input('name');
        $row->value = $request->input('value');
        $row->category_id = $request->category_id ?? 0;
        $row->save();

        return redirect(URL::route('cp.product_parameters.index', ['product_id' =>  $row->product_id]))->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        ProductParameters::where('id', $request->id)->delete();
    }
}
