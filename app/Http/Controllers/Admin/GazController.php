<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\{Gaz};
use App\Http\Request\Admin\Gaz\StoreRequest;
use App\Http\Request\Admin\Gaz\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Image;
use Storage;

class GazController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.gaz.index')->with('title', 'Определяемы газы');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('cp.gaz.create_edit')->with('title', 'Добавление газа');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Gaz::create($request->all());

        return redirect()->route('cp.gaz.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Gaz::find($id);

        if (!$row) abort(404);

        return view('cp.gaz.create_edit', compact('row'))->with('title', 'Редактирование газа');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = Gaz::find($request->id);

        if (!$row) abort(404);

        $row->title = $request->input('title');
        $row->range = $request->input('range');
        $row->chemical_formula = $request->input('chemical_formula');
        $row->chemical_formula_html = $request->input('chemical_formula_html');
        $row->save();

        return redirect()->route('cp.gaz.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        Gaz::find($request->id)->delete();
    }
}
