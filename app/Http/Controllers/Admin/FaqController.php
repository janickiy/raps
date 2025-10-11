<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Faq\StoreRequest;
use App\Http\Requests\Admin\Faq\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqController extends Controller
{

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.faq.index')->with('title', 'Вопрос-ответ');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('cp.faq.create_edit')->with('title', 'Добавление вопрос-ответ');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Faq::create($request->all());

        return redirect()->route('cp.faq.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Faq::find($id);

        if (!$row) abort(404);

        return view('cp.faq.create_edit', compact('row'))->with('title', 'Редактирование вопрос-ответ');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = Faq::find($request->id);

        if (!$row) abort(404);

        $row->question = $request->input('question');
        $row->answer = $request->input('answer');
        $row->save();

        return redirect()->route('cp.faq.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        Faq::find($request->id)->remove();
    }
}
