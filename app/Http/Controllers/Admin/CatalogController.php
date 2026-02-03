<?php

namespace App\Http\Controllers\Admin;


use App\Http\Traits\File;
use App\Repositories\CatalogRepository;
use App\Services\CategoryService;
use App\Helpers\StringHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Catalog;
use App\Http\Requests\Admin\Catalog\{
    StoreRequest,
    EditRequest,
    DeleteRequest,
};
use Exception;

class CatalogController extends Controller
{
    public function __construct(
        private CatalogRepository $categoryRepository,
        private CategoryService  $categoryService
    )
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $catalogsList = $this->categoryRepository->getCatalogsList();

        return view('cp.catalog.index', compact('catalogsList'))->with('title', 'Категории');
    }

    /**
     * @param int $parent_id
     * @return View
     */
    public function create(int $parent_id = 0): View
    {
        $row = $this->categoryRepository->find($parent_id);

        if (!$row) abort(404);

        $options = $this->categoryRepository->getOptions();
        $title = $parent_id > 0 ? 'Добавление подкатегории в категорию ' . $row->name:'Добавление категории';
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.catalog.create_edit', compact('maxUploadFileSize', 'parent_id', 'options'))->with('title', $title);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $seo_sitemap = 0;

            if ($request->input('seo_sitemap')) {
                $seo_sitemap = 1;
            }

            if ($request->hasFile('image')) {
                $image = $this->categoryService->storeImage($request);
            }
            if ($request->hasFile('image')) {
                $image = $this->categoryService->storeImage($request);
            }

            $this->categoryRepository->create(array_merge($request->all(), [
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

        return redirect()->route('cp.catalog.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->categoryRepository->find($id);

        if (!$row) abort(404);

        $options = $this->categoryRepository->getOptions();
        unset($options[$id]);
        $parent_id = $row->parent_id;
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.catalog.create_edit', compact('row', 'parent_id', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование категории');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $seo_sitemap = 0;

            if ($request->input('seo_sitemap')) {
                $seo_sitemap = 1;
            }

            $row = $this->categoryRepository->find($request->id);

            if (!$row) abort(404);

            $image = $request->input('pic');

            if ($image !== null) {
                File::deleteFile($catalog->image, Catalog::getTableName());
                File::deleteFile('2x_' . $catalog->image, Catalog::getTableName());
            }

            if ($request->hasFile('image')) {
                $image = $this->categoryService->updateImage($request, $row);
            }

            $this->categoryRepository->update($request->id, array_merge($request->all(), [
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

        return redirect()->route('cp.catalog.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return RedirectResponse
     */
    public function destroy(DeleteRequest $request): RedirectResponse
    {
        Catalog::removeCatalogs($request->id);

        return redirect()->route('cp.catalog.index')->with('success', 'Данные удалены');
    }
}
