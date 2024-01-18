<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductParametersCategory;
use Illuminate\Http\Request;
use Validator;
use Storage;
use URL;

class ProductParametersCategoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('cp.product_parameters_category.index')->with('title', 'Категории');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('cp.product_parameters_category.create_edit')->with('title', 'Добавление категории');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        ProductParametersCategory::create($request->all());

        return redirect(URL::route('cp.product_parameters_category.index'))->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $row = ProductParametersCategory::find($id);

        if (!$row) abort(404);

        return view('cp.product_parameters_category.create_edit', compact('row'))->with('title', 'Редактирование категории');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $row = ProductParametersCategory::find($request->id);

        if (!$row) abort(404);

        $row->name = $request->input('name');
        $row->save();

        return redirect(URL::route('cp.product_parameters_category.index'))->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        ProductParametersCategory::find($request->id)->delete();
    }
}
