<?php

namespace App\Services;

use App\Http\Traits\File;
use App\Models\Settings;
use Illuminate\Http\Request;
use Exception;

class SettingsService
{

    use File;

    /**
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function storeFile(Request $request): string
    {
        $extension = $request->file('value')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('value')->move('uploads/' . Settings::getTableName(), $filename) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        return $filename;
    }

    /**
     * @param Settings $settings
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function updateFile(Settings $settings, Request $request): string
    {
        File::deleteFile( $settings->filePath(), Settings::getTableName());

        $extension = $request->file('value')->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        if ($request->file('value')->move('uploads/' . Settings::getTableName(), $filename) === false) {
            throw new Exception('Не удалось сохранить файл!');
        }

        return $filename;
    }
}
