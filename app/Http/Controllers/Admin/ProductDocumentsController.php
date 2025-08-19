<?php

namespace App\Http\Controllers\Admin;

use App\Models\{
    ProductDocuments,
    Products,
};
use Illuminate\Http\Request;
use App\Helpers\StringHelper;
use App\Http\Request\Admin\ProductDocuments\StoreRequest;
use App\Http\Request\Admin\ProductDocuments\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Storage;

class ProductDocumentsController extends Controller
{
    /**
     * @param int $product_id
     * @return View
     */
    public function index(int $product_id): View
    {
        $row = Products::find($product_id);

        if (!$row) abort(404);

        return view('cp.product_documents.index', compact('product_id'))->with('title', 'Список документации: ' . $row->title);
    }

    /**
     * @param int $product_id
     * @return View
     */
    public function create(int $product_id): View
    {
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.product_documents.create_edit', compact('product_id', 'maxUploadFileSize'))->with('title', 'Добавление документации');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        if ($request->hasFile('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $request->file('file')->move('uploads/documents', $filename);

            ProductDocuments::create(array_merge($request->all(), ['path' => $filename]));
        }

        return redirect()->route('cp.product_documents.index', ['product_id' => $request->product_id])->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = ProductDocuments::find($id);

        if (!$row) abort(404);

        $product_id = $row->product_id;
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.product_documents.create_edit', compact('row', 'product_id', 'maxUploadFileSize'))->with('title', 'Редактирование списка документации');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = ProductDocuments::find($request->id);

        if (!$row) abort(404);

        if ($request->hasFile('file')) {
            if (Storage::disk('public')->exists('documents/' . $row->path) === true) Storage::disk('public')->delete('documents/' . $row->path);

            $extension = $request->file('file')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $request->file('file')->move('uploads/documents', $filename);
            $row->path = $filename;
        }

        $row->description = $request->input('description');
        $row->save();

        return redirect()->route('cp.product_documents.index', ['product_id' => $row->product_id])->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        ProductDocuments::find($request->id)->remove();
    }
}
