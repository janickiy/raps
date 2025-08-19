<?php

namespace App\Http\Controllers\Admin;

use App\Models\{
    ProductSoft,
    Products,
};
use Illuminate\Http\Request;
use App\Helpers\StringHelper;
use App\Http\Request\Admin\ProductSoft\StoreRequest;
use App\Http\Request\Admin\ProductSoft\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductSoftController extends Controller
{
    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $row = Products::find($product_id);

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
        ProductSoft::create($request->all());

        return redirect()->route('cp.product_soft.index', ['product_id' => $request->product_id])->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = ProductSoft::find($id);

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
        $row = ProductSoft::find($request->id);

        if (!$row) abort(404);

        $row->url =  $request->input('url');
        $row->description = $request->input('description');
        $row->save();

        return redirect()->route('cp.product_soft.index', ['product_id' => $row->product_id])->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        ProductSoft::find($request->id)->remove();
    }
}
