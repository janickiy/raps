<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use URL;

class SitemapController extends Controller
{

    public function index()
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function importForm()
    {
        return view('cp.sitemap.import')->with('title', 'Выгрузка карты sitemap.xml');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function import(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:xml',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->isMethod('post')) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $file->move(public_path(), 'sitemap.xml');
            }
        }

        return redirect(URL::route('cp.sitemap.index'))->with('success', 'Данные обновлены');
    }

}
