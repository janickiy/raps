<?php

namespace App\Http\Controllers\Admin;

use App\Models\{
    ProductDocuments,
    Products,
};
use Illuminate\Http\Request;
use App\Helpers\StringHelper;
use Validator;
use Storage;
use URL;

class ProductDocumentsController extends Controller
{

    /**
     * @param int $product_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(int $product_id)
    {
        $row = Products::find($product_id);

        if (!$row) abort(404);

        return view('cp.product_documents.index', compact('product_id'))->with('title', 'Список документации: ' . $row->title);
    }

    /**
     * @param int $product_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(int $product_id)
    {
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.product_documents.create_edit', compact('product_id', 'maxUploadFileSize'))->with('title', 'Добавление документации');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $rules = [
            'file' => 'file|mimes:jpg,png,doc,pdf,docx,txt,pdf,xls,xlsx,odt,ods',
            'description' => 'required',
            'product_id' => 'required|integer|exists:products,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        if ($request->hasFile('file')) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $request->file('file')->move('uploads/documents', $filename);

            ProductDocuments::create(array_merge($request->all(), ['path' => $filename]));
        }

        return redirect(URL::route('cp.product_documents.index', ['product_id' => $request->product_id]))->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $row = ProductDocuments::find($id);

        if (!$row) abort(404);

        $product_id = $row->product_id;

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.product_documents.create_edit', compact('row', 'product_id', 'maxUploadFileSize'))->with('title', 'Редактирование списка документации');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $rules = [
            'file' => 'nullable|file|mimes:jpg,png,doc,pdf,docx,txt,pdf,xls,xlsx,odt,ods',
            'description' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $row = ProductDocuments::find($request->id);

        if (!$row) abort(404);

        if ($request->hasFile('file')) {
            if (Storage::disk('public')->exists('documents/' . $row->path) === true) Storage::disk('public')->delete('documents/' . $row->path);

            $extension = $request->file('file')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $request->file('file')->move('uploads/documents', $filename);
        }

        $row->description = $request->input('description');
        $row->save();

        return redirect(URL::route('cp.product_documents.index', ['product_id' => $row->product_id]))->with('success', 'Данные обновлены');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        ProductDocuments::find($request->id)->remove();
    }
}
