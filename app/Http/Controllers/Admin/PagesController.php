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
    public function __construct(
        private PagesRepository $pageRepository,
        private PageService $pageService
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.pages.index')->with('title', 'Страницы и разделы');
    }

    public function create(): View
    {
        $options = $this->pageRepository->getOption();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.pages.create_edit', compact('options', 'maxUploadFileSize'))->with('title', 'Добавление раздела');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $image = $request->hasFile('image')
                ? $this->pageService->storeImage($request)
                : null;

            $this->pageRepository->createFromDto(PageData::fromRequest($request, $image));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.pages.index')->with('success', 'Данные успешно добавлены');
    }

    public function edit(int $id): View
    {
        $row = $this->pageRepository->find($id);

        if (!$row) {
            abort(404);
        }

        $options = $this->pageRepository->getOption();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.pages.create_edit', compact('row', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование раздела');
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $image = null;

            if ($request->hasFile('image')) {
                $page = $this->pageRepository->find($request->integer('id'));

                if (!$page) {
                    abort(404);
                }

                $image = $this->pageService->updateImage($request, $page);
            }

            $this->pageRepository->updateFromDto($request->integer('id'), PageData::fromRequest($request, $image));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.pages.index')->with('success', 'Данные успешно обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->pageRepository->remove($request->integer('id'));
    }
}
