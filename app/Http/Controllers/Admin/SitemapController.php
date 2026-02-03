<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Sitemap\EditRequest;
use Illuminate\View\View;

class SitemapController extends Controller
{

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.sitemap.index')->with('title', 'Загрузка и выгрузка файла карты сайта sitemap.xml');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function export(Request $request)
    {
        $file = public_path() . "/sitemap.xml";

        $headers = ['Content-Type: text/xml'];

        return \Response::download($file, 'sitemap.xml', $headers);
    }

    /**
     * @return View
     */
    public function importForm(): View
    {
        return view('cp.sitemap.import')->with('title', 'Выгрузка карты sitemap.xml');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function import(EditRequest $request): RedirectResponse
    {
        if ($request->isMethod('post') && $request->hasFile('file')) {
            $file = $request->file('file');
            $file->move(public_path(), 'sitemap.xml');
        }

        return redirect()->route('cp.sitemap.index')->with('success', 'Данные обновлены');
    }
}
