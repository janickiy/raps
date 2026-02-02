<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use App\Models\Pages;
use App\Repositories\PagesRepository;
use App\Services\PageService;
use App\Http\Requests\Admin\Pages\StoreRequest;
use App\Http\Requests\Admin\Pages\EditRequest;
use App\Http\Requests\Admin\Pages\DeleteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class PagesController extends Controller
{
    /**
     * @param PagesRepository $pageRepository
     * @param PageService $pageService
     */
    public function __construct(
        private PagesRepository $pageRepository,
        private PageService $pageService
    )
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.pages.index')->with('title', 'Страницы и разделы');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $options = $this->pageRepository->getOption();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.pages.create_edit', compact('options', 'maxUploadFileSize'))->with('title', 'Добавление раздела');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            if ($request->hasFile('image')) {
                $image = $this->pageService->storeImage($request);
            }

            $published = 0;

            if ($request->input('published')) {
                $published = 1;
            }

            $seo_sitemap = 0;

            if ($request->input('seo_sitemap')) {
                $seo_sitemap = 1;
            }

            Pages::create(array_merge(array_merge($request->all()), [
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

        return redirect()->route('cp.pages.index')->with('success', 'Данные успешно добавлены');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->pageRepository->find($id);

        if (!$row) abort(404);

        $options = $this->pageRepository->getOption();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.pages.create_edit', compact('row', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование раздела');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            if ($request->hasFile('image')) {
                $page = $this->pageRepository->find($request->id);
                $image = $this->pageService->updateImage($request, $page);
            }

            $published = 0;

            if ($request->input('published')) {
                $published = 1;
            }

            $main = 0;

            if ($request->input('main')) {
                $main = 1;
            }

            $seo_sitemap = 0;

            if ($request->input('seo_sitemap')) {
                $seo_sitemap = 1;
            }

            $this->pageRepository->update($request->id, array_merge($request->all(), [
                'main' => $main,
                'seo_sitemap' => $seo_sitemap,
                'published' => $published,
                'image' => $image ?? null,
            ]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.pages.index')->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->pageRepository->remove($request->id);;
    }
}
