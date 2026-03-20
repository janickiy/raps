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
    public function __construct(private FaqRepository $faqRepository)
    {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.faq.index')->with('title', 'Вопрос-ответ');
    }

    public function create(): View
    {
        return view('cp.faq.create_edit')->with('title', 'Добавление вопрос-ответ');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->faqRepository->createFromDto(FaqData::fromRequest($request));

        return redirect()->route('cp.faq.index')->with('success', 'Информация успешно добавлена');
    }

    public function edit(int $id): View
    {
        $row = $this->faqRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return view('cp.faq.create_edit', compact('row'))->with('title', 'Редактирование вопрос-ответ');
    }

    public function update(EditRequest $request): RedirectResponse
    {
        $row = $this->faqRepository->updateFromDto($request->integer('id'), FaqData::fromRequest($request));

        if (!$row) {
            abort(404);
        }

        return redirect()->route('cp.faq.index')->with('success', 'Данные обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->faqRepository->remove($request->integer('id'));
    }
}
