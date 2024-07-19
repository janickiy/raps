<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Http\Request\Admin\Settings\StoreRequest;
use App\Http\Request\Admin\Settings\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use URL;
use Storage;

class SettingsController extends Controller
{

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.settings.index')->with('title', 'Настройки');
    }

    /**
     * @param string $type
     * @return View
     */
    public function create(string $type): View
    {
        return view('cp.settings.create_edit', compact('type'))->with('title', 'Добавление настроек');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        if ($request->hasFile('value')) {
            $extension = $request->file('value')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;

            if ($request->file('value')->move('uploads/settings', $filename) === false) {
                return redirect(URL::route('cp.settings.index'))->with('error', 'Не удалось сохранить файл!');
            }
        }

        $hide = 0;

        if ($request->input('hide') === null) {
            $hide = 1;
        }

        Settings::create(array_merge(array_merge($request->all()), [
            'value' => $filename ?? $request->input('value'),
            'hide' => $hide,
        ]));

        return redirect(URL::route('cp.settings.index'))->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Settings::find($id);

        if (!$row) abort(404);

        $type = $row->type;

        return view('cp.settings.create_edit', compact('row', 'type'))->with('title', 'Редактирование настроек');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $settings = Settings::find($request->id);

        if (!$settings) abort(404);

        $settings->key_cd = $request->input('key_cd');
        $settings->name = $request->input('name');
        $settings->display_value = $request->input('display_value');
        $settings->hide = $request->input('hide');

        $hide = 0;

        if ($request->input('hide') === null) {
            $hide = 1;
        }

        $settings->hide = $hide;

        if ($request->hasFile('value')) {
            if (Storage::disk('public')->exists('settings/' . $settings->filePath()) === true) Storage::disk('public')->delete('settings/' . $settings->filePath());

            $extension = $request->file('value')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;

            if ($request->file('value')->move('uploads/settings', $filename) === false) {
                return redirect(URL::route('cp.settings.index'))->with('error', 'Не удалось сохранить файл!');
            } else {
                $settings->value = $filename;
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
