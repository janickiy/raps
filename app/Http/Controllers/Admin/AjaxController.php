<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\{Catalog, Pages, Products, Services, ProductParameters};
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
                        ProductParameters::where('product_id', $request->input('id'))->delete();

                        $rows = ProductParameters::query()->where('product_id', $request->input('product_id'))->get();

                        foreach ($rows as $row) {
                            ProductParameters::create([
                                'product_id' => $request->input('id'),
                                'name' => $row->name,
                                'value' => $row->value,
                                'category_id' => $row->category_id
                            ]);
                        }

                        DB::commit();

                        return response()->json(['success' => true]);
                    } catch (\Exception $e) {
                        DB::rollback();

                        return response()->json(['success' => false]);
                    }
            }
        }
    }
}
