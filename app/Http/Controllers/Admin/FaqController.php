<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Admin\FaqData;
use App\Http\Requests\Admin\Faq\DeleteRequest;
use App\Http\Requests\Admin\Faq\EditRequest;
use App\Http\Requests\Admin\Faq\StoreRequest;
use App\Repositories\FaqRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function __construct(
        private readonly FaqRepository $faqRepository
    ) {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.faq.index', [
            'title' => 'Вопрос-ответ',
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('cp.faq.create_edit', [
            'title' => 'Добавление вопрос-ответ',
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->faqRepository->createFromDto(
            FaqData::fromRequest($request)
        );

        return redirect()
            ->route('cp.faq.index')
            ->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('cp.faq.create_edit', [
            'row' => $this->findOrFail($id),
            'title' => 'Редактирование вопрос-ответ',
        ]);
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $id = $request->integer('id');

        $updated = $this->faqRepository->updateFromDto(
            $id,
            FaqData::fromRequest($request)
        );

        if (!$updated) {
            abort(404);
        }

        return redirect()
            ->route('cp.faq.index')
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

        $this->faqRepository->remove($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function findOrFail(int $id): mixed
    {
        $row = $this->faqRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return $row;
    }
}
