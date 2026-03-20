<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DetectedGases\DeleteRequest;
use App\Http\Requests\Admin\DetectedGases\EditRequest;
use App\Http\Requests\Admin\DetectedGases\StoreRequest;
use App\Repositories\DetectedGasesRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DetectedGasesController extends Controller
{
    public function __construct(
        private readonly DetectedGasesRepository $detectedGasesRepository,
    ) {
        parent::__construct();
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $product = $this->findOrFail($product_id);
        $rows = $this->detectedGasesRepository->getProducts($product_id);

        return view('cp.detected_gases.index', [
            'product_id' => $product_id,
            'rows' => $rows,
            'product' => $product,
            'title' => 'Определяемые газы: ' . $product->title,
        ]);
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function create(int $product_id): View
    {
        $this->findOrFail($product_id);

        return view('cp.detected_gases.create_edit', [
            'product_id' => $product_id,
            'title' => 'Добавление определяемого газа',
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $productId = $request->integer('product_id');

        try {
            $this->findOrFail($productId);

            $this->detectedGasesRepository->create($request->all());
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('cp.detected_gases.index', ['product_id' => $productId])
            ->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->findOrFail($id);

        return view('cp.detected_gases.create_edit', [
            'row' => $row,
            'product_id' => $row->product_id,
            'title' => 'Редактирование определяемого газа',
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
            $row = $this->findOrFail($id);

            $updated = $this->detectedGasesRepository->update($id, $request->all());

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
            ->route('cp.detected_gases.index', ['product_id' => $row->product_id])
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

        $this->detectedGasesRepository->delete($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    private function findOrFail(int $id): mixed
    {
        $row = $this->detectedGasesRepository->find($id);

        if (!$row) {
            abort(404);
        }

        return $row;
    }
}
