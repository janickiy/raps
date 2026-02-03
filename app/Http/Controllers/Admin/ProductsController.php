<?php

namespace App\Http\Controllers\Admin;


use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Products\DeleteRequest;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Repositories\PagesRepository;
use App\Repositories\WerRepository;
use App\Services\PageService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductsController extends Controller
{
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
        return view('cp.products.index')->with('title', 'Продукция');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $options = $this->categoryRepository->getOptions();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.products.create_edit', compact('options', 'maxUploadFileSize'))->with('title', 'Добавление продукции');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            if ($request->hasFile('image')) {
                $filename = $this->productService->storeImage($request);
                $fileNameToStore = 'origin_' . $filename;
                $thumbnailFileNameToStore = 'thumbnail_' . $filename;
            }

            $seo_sitemap = 0;

            if ($request->input('seo_sitemap')) {
                $seo_sitemap = 1;
            }

            $this->productsRepository->create(array_merge(array_merge($request->all()), [
                'thumbnail' => $thumbnailFileNameToStore ?? null,
                'origin' => $fileNameToStore ?? null,
                'seo_sitemap' => $seo_sitemap,
            ]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.products.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->productsRepository->find($id);

        if (!$row) abort(404);

        $options = $this->categoryRepository->getOptions();
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.products.create_edit', compact('row', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование продукции');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            if ($request->hasFile('image')) {
                $product = $this->productsRepository->find($request->id);
                $this->productService->updateImage($request, $product);
            }

            $published = 0;

            if ($request->input('published')) {
                $published = 1;
            }

            $seo_sitemap = 0;

            if ($request->input('seo_sitemap')) {
                $seo_sitemap = 1;
            }

            $this->productsRepository->update($request->id, array_merge($request->all(), [
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

        return redirect()->route('cp.products.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->productsRepository->remove($request->id);
    }
}
