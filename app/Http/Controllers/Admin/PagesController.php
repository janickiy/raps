<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Admin\PageData;
use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Pages\DeleteRequest;
use App\Http\Requests\Admin\Pages\EditRequest;
use App\Http\Requests\Admin\Pages\StoreRequest;
use App\Repositories\PagesRepository;
use App\Services\PageService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PagesController extends Controller
{
    /**
     * @param PagesRepository $pageRepository
     * @param PageService $pageService
     */
    public function __construct(
        private readonly PagesRepository $pageRepository,
        private readonly PageService $pageService
    ) {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.pages.index', [
            'title' => 'Страницы и разделы',
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('cp.pages.create_edit', [
            'title' => 'Добавление раздела',
            'options' => $this->pageRepository->getOption(),
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $image = $request->hasFile('image')
                ? $this->pageService->storeImage($request)
                : null;

            $this->pageRepository->createFromDto(
                PageData::fromRequest($request, $image)
            );
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('cp.pages.index')
            ->with('success', 'Данные успешно добавлены');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('cp.pages.create_edit', [
            'row' => $this->findOrFail($id),
            'title' => 'Редактирование раздела',
            'options' => $this->pageRepository->getOption(),
            'maxUploadFileSize' => StringHelper::maxUploadFileSize(),
        ]);
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $id = $request->integer('id');

        try {
            $page = $this->findOrFail($id);

            $image = $request->hasFile('image')
                ? $this->pageService->updateImage($request, $page)
                : null;

            $updated = $this->pageRepository->updateFromDto(
                $id,
                PageData::fromRequest($request, $image)
            );

            if (!$updated) {
                abort(404);
            }
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('cp.pages.index')
            ->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $id = $request->integer('id');

        $this->findOrFail($id);

        $this->pageRepository->remove($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function findOrFail(int $id): mixed
    {
        $row = $this->pageRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return $row;
    }
}
