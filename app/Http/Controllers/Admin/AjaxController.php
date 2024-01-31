<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\{Catalog, Pages, Products, Services};
use App\Helpers\StringHelper;
use URL;

class AjaxController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->input('action')) {
            switch ($request->input('action')) {
                case 'get_content_slug':

                    $slug = StringHelper::slug(trim($request->title));
                    $count = Pages::where('slug', 'LIKE%', $slug)->count();
                    $slug = $count > 0 ? $slug . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);

                case 'get_products_slug':

                    $slug = StringHelper::slug(trim($request->title));
                    $count = Products::where('slug', 'LIKE%', $slug)->count();
                    $slug = $count > 0 ? $slug . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);

                case 'get_services_slug':

                    $slug = StringHelper::slug(trim($request->title));
                    $count = Services::where('slug', 'LIKE%', $slug)->count();
                    $slug = $count > 0 ? $slug . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);

                case 'get_catalog_slug':

                    $slug = StringHelper::slug(trim($request->name));
                    $count = Catalog::where('slug', 'LIKE%', $slug)->count();
                    $slug = $count > 0 ? $slug . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);


            }
        }
    }
}
