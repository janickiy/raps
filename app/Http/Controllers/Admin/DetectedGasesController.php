<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\DetectedGases\EditRequest;
use App\Http\Requests\Admin\DetectedGases\StoreRequest;
use App\Http\Requests\Admin\Pages\DeleteRequest;
use App\Repositories\DetectedGasesRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class DetectedGasesController extends Controller
{
    public function __construct(
        private DetectedGasesRepository $detectedGasesRepository,
    )
    {
        parent::__construct();
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $product = $this->detectedGasesRepository->find($product_id);

        if (!$product) abort(404);

        $rows = $this->detectedGasesRepository->getProducts($product_id);

        return view('cp.detected_gases.index', compact('product_id', 'rows', 'product'))->with('title', 'Определяемые газы: ' . $product->title);
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function create(int $product_id): View
    {
        return view('cp.detected_gases.create_edit', compact('product_id'))->with('title', 'Добавление определяемого газа');
    }


    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->detectedGasesRepository->create($request->all());

        return redirect()->route('cp.detected_gases.index', ['product_id' => $request->product_id])->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->detectedGasesRepository->find($id);

        if (!$row) abort(404);

        $product_id = $row->product_id;

        return view('cp.detected_gases.create_edit', compact('row', 'product_id'))->with('title', 'Редактирование определяемого газа');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $row = $this->detectedGasesRepository->find($request->id);

            if (!$row) abort(404);

            $this->detectedGasesRepository->update($request->id, $request->all());
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('cp.detected_gases.index', ['product_id' => $row->product_id])->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->detectedGasesRepository->delete($request->id);
    }
}
