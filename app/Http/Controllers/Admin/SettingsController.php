<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Admin\SettingData;
use App\Http\Requests\Admin\Settings\DeleteRequest;
use App\Http\Requests\Admin\Settings\EditRequest;
use App\Http\Requests\Admin\Settings\StoreRequest;
use App\Repositories\SettingsRepository;
use App\Services\SettingsService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function __construct(
        private SettingsService $settingsService,
        private SettingsRepository $settingsRepository,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.settings.index')->with('title', 'Настройки');
    }

    public function create(string $type): View
    {
        return view('cp.settings.create_edit', compact('type'))->with('title', 'Добавление настроек');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $value = $request->hasFile('value')
                ? $this->settingsService->storeFile($request)
                : $request->input('value');

            $this->settingsRepository->createFromDto(SettingData::fromRequest($request, $value));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.settings.index')->with('success', 'Информация успешно добавлена');
    }

    public function edit(int $id): View
    {
        $row = $this->settingsRepository->find($id);

        if (!$row) {
            abort(404);
        }

        $type = $row->type;

        return view('cp.settings.create_edit', compact('row', 'type'))->with('title', 'Редактирование настроек');
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $settings = $this->settingsRepository->find($request->integer('id'));

            if (!$settings) {
                abort(404);
            }

            $value = $request->hasFile('value')
                ? $this->settingsService->updateFile($settings, $request)
                : $request->input('value', $settings->filePath());

            $this->settingsRepository->updateFromDto(
                $settings->id,
                SettingData::fromRequest($request, $value),
            );
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.settings.index')->with('success', 'Данные обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->settingsRepository->remove($request->integer('id'));
    }
}
