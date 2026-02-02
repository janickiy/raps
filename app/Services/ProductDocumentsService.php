<?php

namespace App\Services;

use App\Models\ProductDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProductDocumentsService
{
    /**
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function storeFile(Request $request): string
    {
        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('file')->move('uploads/' . ProductDocuments::getTableName(), $filename) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        return $filename;
    }

    /**
     * @param ProductDocuments $productDocument
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function updateFile(ProductDocuments $productDocument, Request $request): string
    {
        if (Storage::disk('public')->exists(ProductDocuments::getTableName() . '/' . $productDocument->path) === true) {
            Storage::disk('public')->delete(ProductDocuments::getTableName() . '/' . $productDocument->path);
        }

        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('file')->move('uploads/' . ProductDocuments::getTableName(), $filename) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        return $filename;
    }
}
