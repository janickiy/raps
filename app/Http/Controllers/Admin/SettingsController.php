<?php

namespace App\Http\Controllers\Admin;

use App\Services\SettingsService;
use App\Repositories\SettingsRepository;
use App\Http\Requests\Admin\Settings\StoreRequest;
use App\Http\Requests\Admin\Settings\EditRequest;
use App\Http\Requests\Admin\Settings\DeleteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class SettingsController extends Controller
{

    /**
     * @param SettingsService $settingsService
     * @param SettingsRepository $settingsRepository
     */
    public function __construct(
        private SettingsService $settingsService,
        private SettingsRepository $settingsRepository
    )
    {
        parent::__construct();
    }

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
        try {
            if ($request->hasFile('value')) {
                $this->settingsService->storeFile($request);
            }

            $published = 0;

            if ($request->input('published')) {
                $published = 1;
            }

            $this->settingsRepository->create(array_merge(array_merge($request->all()), [
                'value' => $res ?? $request->input('value'),
                'published' => $published,
            ]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.settings.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->settingsRepository->find($id);

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
        $settings = $this->settingsRepository->find($request->id);

        $published = 0;

        if ($request->input('published')) {
            $published = 1;
        }

        if ($request->hasFile('value')) {
            $res = $this->settingsService->updateFile($settings, $request);

            if ($res === false) {
                return redirect()->route('cp.settings.index')->with('error', 'Не удалось сохранить файл!');
            }
        }

        $this->settingsRepository->update($settings->id, array_merge(array_merge($request->all()), [
            'value' => $res ?? $request->input('value'),
            'published' => $published,
        ]));

        return redirect()->route('cp.settings.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->settingsRepository->remove($request->id);
    }
}
