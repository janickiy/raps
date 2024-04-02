<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Request\Admin\Sitemap\ImportRequest;
use Illuminate\View\View;
use URL;

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
        $file = public_path(). "/sitemap.xml";

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
     * @param ImportRequest $request
     * @return RedirectResponse
     */
    public function import(ImportRequest $request): RedirectResponse
    {

        if ($request->isMethod('post')) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $file->move(public_path(), 'sitemap.xml');
            }
        }

        return redirect(URL::route('cp.sitemap.index'))->with('success', 'Данные обновлены');
    }

}
