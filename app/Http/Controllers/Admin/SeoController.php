<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\SeoRepository;
use App\Http\Requests\Admin\Seo\EditRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Exception;

class SeoController extends Controller
{
    /**
     * @param SeoRepository $seoRepository
     */
    public function __construct(private SeoRepository $seoRepository)
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.seo.index')->with('title', 'Seo');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->seoRepository->find($id);

        if (!$row) abort(404);

        return view('cp.seo.edit', compact('row'))->with('title', 'Редактирование seo');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $this->seoRepository->update($request->id, $request->all());
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.seo.index')->with('success', 'Данные успешно обновлены');
    }
}
