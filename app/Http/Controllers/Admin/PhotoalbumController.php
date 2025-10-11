<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Photoalbum\EditRequest;
use App\Http\Requests\Admin\Photoalbum\StoreRequest;
use App\Models\Photoalbum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PhotoalbumController extends Controller
{
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

        $seo_sitemap = 0;

        if ($request->input('seo_sitemap')) {
            $seo_sitemap = 1;
        }

        Photoalbum::create(array_merge($request->all(), ['seo_sitemap' => $seo_sitemap]));

        return redirect()->route('cp.photoalbum.index')->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Photoalbum::find($id);

        if (!$row) abort(404);

        return view('cp.photoalbum.create_edit', compact('row'))->with('title', 'Редактирование фотоальбома');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = Photoalbum::find($request->id);

        if (!$row) abort(404);

        $row->name = $request->input('name');
        $row->description = $request->input('description');
        $row->meta_title = $request->input('meta_title');
        $row->meta_description = $request->input('meta_description');
        $row->meta_keywords = $request->input('meta_keywords');
        $row->slug = $request->input('slug');
        $row->seo_h1 = $request->input('seo_h1');
        $row->seo_url_canonical = $request->input('seo_url_canonical');
        $seo_sitemap = 0;

        if ($request->input('seo_sitemap')) {
            $seo_sitemap = 1;
        }

        $row->seo_sitemap = $seo_sitemap;
        $row->save();

        return redirect()->route('cp.photoalbum.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        Photoalbum::find($request->id)->remove();
    }
}
