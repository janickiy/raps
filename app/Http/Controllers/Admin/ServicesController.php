<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use App\Repositories\ServicesRepository;
use App\Services\ServicesService;
use App\Http\Requests\Admin\Services\StoreRequest;
use App\Http\Requests\Admin\Services\EditRequest;
use App\Http\Requests\Admin\Services\DeleteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class ServicesController extends Controller
{
    /**
     * @param ServicesRepository $servicesRepository
     * @param ServicesService $servicesService
     */
    public function __construct(
        private ServicesRepository $servicesRepository,
        private ServicesService    $servicesService,
    )
    {
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
            if ($request->hasFile('image')) {
                $image = $this->servicesService->storeImage($request);
            }

            $published = 0;

            if ($request->input('published')) {
                $published = 1;
            }

            $seo_sitemap = 0;

            if ($request->input('seo_sitemap')) {
                $seo_sitemap = 1;
            }

            $this->servicesRepository->create(array_merge(array_merge($request->all()), [
                'image' => $image ?? null,
                'published' => $published,
                'seo_sitemap' => $seo_sitemap,
            ]));
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

        if (!$row) abort(404);

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
            $published = 0;

            if ($request->input('published')) {
                $published = 1;
            }

            $seo_sitemap = 0;

            if ($request->input('seo_sitemap')) {
                $seo_sitemap = 1;
            }

            $row = $this->servicesRepository->find($request->id);

            if (!$row) abort(404);

            $image = $this->servicesService->updateImage($request, $row);

            $this->servicesRepository->update($request->id, array_merge(array_merge($request->all()), [
                'published' => $published,
                'seo_sitemap' => $seo_sitemap,
                'image' => $image ?? null,
            ]));

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
        $this->servicesRepository->remove($request->id);
    }
}
