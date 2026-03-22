<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Admin\CatalogData;
use App\Helpers\StringHelper;
use App\Http\Requests\Admin\Catalog\DeleteRequest;
use App\Http\Requests\Admin\Catalog\EditRequest;
use App\Http\Requests\Admin\Catalog\StoreRequest;
use App\Models\Catalog;
use App\Repositories\CatalogRepository;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __construct(
        private CatalogRepository $categoryRepository,
        private CategoryService $categoryService,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        $catalogsList = $this->categoryRepository->getCatalogsList();

        return view('cp.catalog.index', compact('catalogsList'))->with('title', 'Категории');
    }

    public function create(int $parent_id = 0): View
    {
        $row = null;

        if ($parent_id > 0) {
            $row = $this->categoryRepository->find($parent_id);

            if (!$row) {
                abort(404);
            }
        }

        $options = $this->categoryRepository->getOptions();
        $title = $parent_id > 0
            ? 'Добавление подкатегории в категорию ' . $row->name
            : 'Добавление категории';
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.catalog.create_edit', compact('maxUploadFileSize', 'parent_id', 'options'))->with('title', $title);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $image = $request->hasFile('image')
                ? $this->categoryService->storeImage($request)
                : null;

            $this->categoryRepository->createFromDto(CatalogData::fromRequest($request, $image));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.catalog.index')->with('success', 'Информация успешно добавлена');
    }

    public function edit(int $id): View
    {
        $row = $this->categoryRepository->find($id);

        if (!$row) {
            abort(404);
        }

        $options = $this->categoryRepository->getOptions();
        unset($options[$id]);
        $parent_id = $row->parent_id;
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.catalog.create_edit', compact('row', 'parent_id', 'options', 'maxUploadFileSize'))->with('title', 'Редактирование категории');
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $row = $this->categoryRepository->find($request->integer('id'));

            if (!$row) {
                abort(404);
            }

            $image = $request->hasFile('image')
                ? $this->categoryService->updateImage($request, $row)
                : null;

            $this->categoryRepository->updateFromDto(
                $request->integer('id'),
                CatalogData::fromRequest($request, $image),
            );
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.catalog.index')->with('success', 'Данные обновлены');
    }

    public function destroy(DeleteRequest $request): RedirectResponse
    {
        Catalog::removeCatalogs((int) $request->route('id'));

        return redirect()->route('cp.catalog.index')->with('success', 'Данные удалены');
    }
}
