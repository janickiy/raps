<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PhotoAlbum\DeleteRequest;
use App\Http\Requests\Admin\PhotoAlbum\EditRequest;
use App\Http\Requests\Admin\PhotoAlbum\StoreRequest;
use App\Repositories\PhotoAlbumRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PhotoAlbumController extends Controller
{
    public function __construct(
        private readonly PhotoAlbumRepository $photoAlbumRepository,
    ) {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.photoalbum.index', [
            'title' => 'Фотоальбом',
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('cp.photoalbum.create_edit', [
            'title' => 'Добавление',
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $this->photoAlbumRepository->create(
                $this->prepareData($request->all())
            );
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('cp.photoalbum.index')
            ->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('cp.photoalbum.create_edit', [
            'row' => $this->findOrFail($id),
            'title' => 'Редактирование фотоальбома',
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
            $this->findOrFail($id);

            $updated = $this->photoAlbumRepository->update(
                $id,
                $this->prepareData($request->all())
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
            ->route('cp.photoalbum.index')
            ->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $id = $request->integer('id');

        $this->findOrFail($id);

        $this->photoAlbumRepository->remove($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function findOrFail(int $id): mixed
    {
        $row = $this->photoAlbumRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return $row;
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareData(array $data): array
    {
        $data['seo_sitemap'] = !empty($data['seo_sitemap']) ? 1 : 0;

        return $data;
    }
}
