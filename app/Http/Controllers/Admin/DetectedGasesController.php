<?php

namespace App\Http\Controllers\Admin;

use App\Http\Request\Admin\DetectedGases\EditRequest;
use App\Http\Request\Admin\DetectedGases\StoreRequest;
use App\Models\Products;
use App\Models\DetectedGases;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DetectedGasesController extends Controller
{
    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $parameters = DetectedGases::where('product_id', $product_id)->get();

        if (!$parameters) abort(404);

        $rows = Products::query()->where('published', 1)->orderBy('title')->get();

        return view('cp.detected_gases.index', compact('parameters', 'product_id', 'rows'))->with('title', 'Технические характеристики');
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function create(int $product_id): View
    {
        return view('cp.detected_gases.create_edit', compact('product_id'))->with('title', 'Добавление параметра');
    }

    /**
     * @param \App\Http\Request\Admin\ProductParameters\StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        DetectedGases::create($request->all());

        return redirect()->route('cp.detected_gases.index', ['product_id' => $request->product_id])->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = DetectedGases::find($id);

        if (!$row) abort(404);

        $product_id = $row->product_id;

        return view('cp.detected_gases.create_edit', compact('row', 'product_id'))->with('title', 'Редактирование параметра');
    }

    /**
     * @param \App\Http\Request\Admin\ProductParameters\EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = DetectedGases::find($request->id);

        if (!$row) abort(404);

        $row->name = $request->input('name');
        $row->formula = $request->input('formula');
        $row->volume_fraction = $request->input('volume_fraction');
        $row->save();

        return redirect()->route('cp.detected_gases.index', ['product_id' => $row->product_id])->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        DetectedGases::where('id', $request->id)->delete();
    }
}
