<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\{Catalog, DetectedGases, Pages, Products, Services};
use App\Helpers\StringHelper;
use Illuminate\Support\Facades\DB;
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
                    $count = Pages::where('slug', 'LIKE', $slug)->count();
                    $slug = $count > 0 ? substr($slug, 0, -1) . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);

                case 'get_products_slug':
                    $slug = StringHelper::slug(trim($request->title));
                    $count = Products::where('slug', 'LIKE', $slug)->count();
                    $slug = $count > 0 ? substr($slug, 0, -1) . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);

                case 'get_services_slug':
                    $slug = StringHelper::slug(trim($request->title));
                    $count = Services::where('slug', 'LIKE', $slug)->count();
                    $slug = $count > 0 ? substr($slug, 0, -1) . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);

                case 'get_catalog_slug':
                    $slug = StringHelper::slug(trim($request->name));
                    $count = Catalog::where('slug', 'LIKE', $slug)->count();
                    $slug = $count > 0 ? substr($slug, 0, -1) . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);

                case 'add_product_parameters':

                    DB::beginTransaction();

                    try {
                        DetectedGases::where('product_id', $request->input('product_id'))->delete();

                        $rows = DetectedGases::query()->where('product_id', $request->input('id'))->get();

                        foreach ($rows as $row) {
                            DetectedGases::create([
                                'product_id' => (int)$request->input('product_id'),
                                'name' => $row->name,
                                'formula' => $row->formula,
                                'volume_fraction' => $row->volume_fraction,
                            ]);
                        }

                        DB::commit();

                        return response()->json(['result' => true]);
                    } catch (\Exception $e) {
                        DB::rollback();

                        return response()->json(['result' => false]);
                    }
            }
        }
    }
}
