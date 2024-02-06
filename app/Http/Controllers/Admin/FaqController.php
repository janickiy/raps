<?php

namespace App\Http\Controllers\Admin;


use App\Models\Faq;
use Illuminate\Http\Request;
use Validator;
use URL;

class FaqController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('cp.faq.index')->with('title', 'Вопрос-ответ');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('cp.faq.create_edit')->with('title', 'Добавление вопрос-ответ');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'question' => 'required',
            'answer' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        Faq::create($request->all());

        return redirect(URL::route('cp.faq.index'))->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $row = Faq::find($id);

        if (!$row) abort(404);

        return view('cp.faq.create_edit', compact('row'))->with('title', 'Редактирование вопрос-ответ');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'question' => 'required',
            'answer' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $row = Faq::find($request->id);

        if (!$row) abort(404);

        $row->question = $request->input('question');
        $row->answer = $request->input('answer');
        $row->save();

        return redirect(URL::route('cp.faq.index'))->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Faq::find($request->id)->remove();
    }
}
