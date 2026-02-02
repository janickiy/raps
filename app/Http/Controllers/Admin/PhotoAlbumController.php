<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\PhotoAlbum\EditRequest;
use App\Http\Requests\Admin\PhotoAlbum\StoreRequest;
use App\Http\Requests\Admin\PhotoAlbum\DeleteRequest;
use App\Repositories\PhotoAlbumRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class PhotoAlbumController extends Controller
{
    /**
     * @param PhotoAlbumRepository $photoAlbumRepository
     */
    public function __construct(
        private PhotoAlbumRepository $photoAlbumRepository,
    )
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.photoalbum.index')->with('title', 'Фотоальбом');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('cp.photoalbum.create_edit')->with('title', 'Добавление');
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

            $this->photoAlbumRepository->create(array_merge($request->all(), ['seo_sitemap' => $seo_sitemap]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.photoalbum.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->photoAlbumRepository->find($id);

        if (!$row) abort(404);

        return view('cp.photoalbum.create_edit', compact('row'))->with('title', 'Редактирование фотоальбома');
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

            $this->photoAlbumRepository->update($request->id, array_merge($request->all(), ['seo_sitemap' => $seo_sitemap]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.photoalbum.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->photoAlbumRepository->remove($request->id);;
    }
}
