<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Settings;
use Illuminate\Support\Facades\Validator;
use URL;
use Storage;

class SettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('cp.settings.index')->with('title', 'Настройки');
    }

    /**
     * @param string $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(string $type)
    {
        return view('cp.settings.create_edit', compact('type'))->with('title', 'Добавление настроек');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'key_cd' => 'required|unique:settings|max:255',
            'type' => 'required',
        ]);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        if ($request->hasFile('value')) {
            $extension = $request->file('value')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;

            if ($request->file('value')->move('uploads/settings', $filename) === false) {
                return redirect(URL::route('cp.settings.index'))->with('error', 'Не удалось сохранить файл!');
            }
        }

        Settings::create(array_merge(array_merge($request->all()), [
            'value' => $filename ?? $request->input('value')
        ]));

        return redirect(URL::route('cp.settings.index'))->with('success', 'Информация успешно добавлена');

    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $row = Settings::find($id);

        if (!$row) abort(404);

        $type = $row->type;

        return view('cp.settings.create_edit', compact('row', 'type'))->with('title', 'Редактирование настроек');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $settings = Settings::find($request->id);

        if (!$settings) abort(404);

        $rules = [
            'value' => $settings->type == 'FILE' ? 'nullable' : 'required',
            'key_cd' => 'required|max:255|unique:settings,key_cd,' . $request->id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $settings->key_cd = $request->input('key_cd');
        $settings->display_value = $request->input('display_value');

        if ($settings->type == 'TEXT' && $request->hasFile('value')) {

            if (Storage::disk('public')->exists('settings/' . $settings->filePath()) === true) Storage::disk('public')->delete('settings/' . $settings->filePath());

            $extension = $request->file('value')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;

            if ($request->file('value')->move('uploads/settings', $filename)) {
                $settings->value = $filename;
            } else {
                return redirect(URL::route('cp.settings.index'))->with('error', 'Не удалось сохранить файл!');
            }
        } else {
            if (!empty($request->value)) $settings->value = $request->input('value');
        }

        $settings->save();

        return redirect(URL::route('cp.settings.index'))->with('success', 'Данные обновлены');

    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        Settings::find($request->id)->remove();
    }
}
