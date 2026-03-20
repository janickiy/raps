<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Admin\ServiceData;
use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Services\DeleteRequest;
use App\Http\Requests\Admin\Services\EditRequest;
use App\Http\Requests\Admin\Services\StoreRequest;
use App\Repositories\ServicesRepository;
use App\Services\ServicesService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServicesController extends Controller
{
    /**
     * @param ServicesRepository $servicesRepository
     * @param ServicesService $servicesService
     */
    public function __construct(
        private ServicesRepository $servicesRepository,
        private ServicesService $servicesService,
    ) {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.services.index')->with('title', 'Услуги');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.services.create_edit', compact('maxUploadFileSize'))->with('title', 'Добавление услугу');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $image = $request->hasFile('image')
                ? $this->servicesService->storeImage($request)
                : null;

            $this->servicesRepository->createFromDto(ServiceData::fromRequest($request, $image));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.services.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->servicesRepository->find($id);

        if (!$row) {
            abort(404);
        }

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.services.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование услуги');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $row = $this->servicesRepository->find($request->integer('id'));

            if (!$row) {
                abort(404);
            }

            $image = $request->hasFile('image')
                ? $this->servicesService->updateImage($request, $row)
                : null;

            $this->servicesRepository->updateFromDto(
                $request->integer('id'),
                ServiceData::fromRequest($request, $image),
            );
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.services.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->servicesRepository->remove($request->integer('id'));
    }
}
