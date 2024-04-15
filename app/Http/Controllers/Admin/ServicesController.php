<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StringHelper;
use App\Models\Services;
use Illuminate\Http\Request;
use App\Http\Request\Admin\Services\StoreRequest;
use App\Http\Request\Admin\Services\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Image;
use Storage;
use URL;

class ServicesController extends Controller
{

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.services.index')->with('title', 'Продукция');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.services.create_edit', compact('maxUploadFileSize'))->with('title', 'Добавление продукции');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Services::create($request->all());

        return redirect(URL::route('cp.services.index'))->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = Services::find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.services.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование продукции');

    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = Services::find($request->id);

        if (!$row) abort(404);

        $row->title = $request->input('title');
        $row->description = $request->input('description');
        $row->full_description = $request->input('full_description');
        $row->meta_title = $request->input('meta_title');
        $row->meta_description = $request->input('meta_description');
        $row->meta_keywords = $request->input('meta_keywords');
        $row->slug = $request->input('slug');
        $row->seo_h1 = $request->input('seo_h1');
        $row->seo_url_canonical = $request->input('seo_url_canonical');

        $published = 0;

        if ($request->input('published')) {
            $published = 1;
        }

        $row->published = $published;

        $row->save();

        return redirect(URL::route('cp.services.index'))->with('success', 'Данные обновлены');

    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request): Void
    {
        Services::find($request->id)->delete();
    }
}
