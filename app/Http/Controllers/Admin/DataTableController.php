<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Catalog,
    DetectedGases,
    Pages,
    Photoalbum,
    ProductDocuments,
    ProductSoft,
    ProductParameters,
    ProductParametersCategory,
    ProductPhotos,
    Photos,
    Products,
    Requests,
    Settings,
    Seo,
    Services,
    User,
    Faq
};
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use DataTables;
use URL;

class DataTableController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        $row = User::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.users.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';

                if ($row->id != Auth::id())
                    $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';
                else
                    $deleteBtn = '';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     */
    public function getServices(): JsonResponse
    {
        $row = Services::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary" href="' . URL::route('cp.services.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('image', function ($row) {
                return '<img  height="150" src="' . url($row->getImage()) . '" alt="" loading="lazy">';
            })
            ->rawColumns(['actions', 'image'])->make(true);
    }

    /**
     * @return JsonResponse
     */
    public function getPages(): JsonResponse
    {
        $row = Pages::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.pages.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('main', function ($row) {
                return $row->main ? 'да' : 'нет';
            })
            ->rawColumns(['actions'])->make(true);
    }


    /**
     * @return JsonResponse
     */
    public function getRequests(): JsonResponse
    {
        $row = Requests::query();

        return Datatables::of($row)
            ->editColumn('type', function ($row) {
                return Requests::$type_name[$row->type];
            })
            ->make(true);
    }

    /**
     * @return JsonResponse
     */
    public function getSettings(): JsonResponse
    {
        $row = Settings::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.settings.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('published', function ($row) {
                return $row->published == 1 ? 'да' : 'нет';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     */
    public function getSeo(): JsonResponse
    {
        $row = Seo::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.seo.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a>';

                return '<div class="nobr"> ' . $editBtn . '</div>';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     */
    public function getCatalog(): JsonResponse
    {
        $row = Catalog::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.catalog.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('image', function ($row) {
                return '<img  height="150" src="' . url($row->getImage()) . '" alt="" loading="lazy">';
            })
            ->rawColumns(['actions', 'image'])->make(true);
    }

    /**
     * @return JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        $row = Products::selectRaw('products.id,products.title,products.price,products.published,products.catalog_id,products.slug,products.created_at,products.description,catalog.name AS catalog')
            ->leftJoin('catalog', 'catalog.id', '=', 'products.catalog_id')
            ->groupBy('catalog.name')
            ->groupBy('products.id')
            ->groupBy('products.title')
            ->groupBy('products.catalog_id')
            ->groupBy('products.slug')
            ->groupBy('products.price')
            ->groupBy('products.published')
            ->groupBy('products.description')
            ->groupBy('products.created_at')
            ->groupBy('products.description');

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary" href="' . URL::route('cp.products.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('title', function ($row) {
                $title = $row->title;
                $title .= '<br><br><a href="' . URL::route('cp.product_photos.index', ['product_id' => $row->id]) . '">Фото</a><br>';
                $title .= '<br><a href="' . URL::route('cp.product_documents.index', ['product_id' => $row->id]) . '">Документы</a><br>';
                $title .= '<br><a href="' . URL::route('cp.product_soft.index', ['product_id' => $row->id]) . '">Программное обеспечение</a><br>';
                $title .= '<br><a href="' . URL::route('cp.product_parameters.index', ['product_id' => $row->id]) . '">Характеристики</a><br>';
                $title .= '<br><a href="' . URL::route('cp.detected_gases.index', ['product_id' => $row->id]) . '">Определяемые газы</a>';

                return $title;
            })
            ->editColumn('thumbnail', function ($row) {
                $product = Products::find($row->id);

                return '<img  height="150" src="' . url($product->getThumbnailUrl()) . '" alt="" loading="lazy">';
            })
            ->editColumn('published', function ($row) {
                return $row->published == 1 ? 'опубликован' : 'не опубликован';
            })
            ->rawColumns(['actions', 'title', 'thumbnail'])->make(true);
    }

    /**
     * @param int $product_id
     * @return JsonResponse
     */
    public function getProductPhotos(int $product_id): JsonResponse
    {
        $row = ProductPhotos::where('product_id', $product_id);

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.product_photos.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('thumbnail', function ($row) {
                return '<img  height="150" src="' . url($row->getThumbnailUrl()) . '" alt="" loading="lazy">';
            })
            ->rawColumns(['actions', 'thumbnail'])->make(true);
    }

    /**
     * @param int $product_id
     * @return JsonResponse
     */
    public function getProductParameters(int $product_id): JsonResponse
    {
        $row = ProductParameters::selectRaw('product_parameters.id, product_parameters.name, product_parameters.value, product_parameters.product_id, product_parameters.category_id, product_parameters_category.name AS category')
            ->leftJoin('product_parameters_category', 'product_parameters_category.id', '=', 'product_parameters.category_id')
            ->where('product_id', $product_id)
            ->groupBy('product_parameters_category.name')
            ->groupBy('product_parameters.id')
            ->groupBy('product_parameters.name')
            ->groupBy('product_parameters.value')
            ->groupBy('product_parameters.product_id')
            ->groupBy('product_parameters.category_id');

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.product_parameters.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('category', function ($row) {
                return $row->category ?? 'Разное';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @param int $product_id
     * @return JsonResponse
     */
    public function getDocuments(int $product_id): JsonResponse
    {
        $row = ProductDocuments::where('product_id', $product_id);

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.product_documents.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @param int $product_id
     * @return JsonResponse
     */
    public function getSoft(int $product_id): JsonResponse
    {
        $row = ProductSoft::where('product_id', $product_id);

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.product_soft.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     */
    public function getProductParametersCategory(): JsonResponse
    {
        $row = ProductParametersCategory::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.product_parameters_category.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     */
    public function getFaq(): JsonResponse
    {
        $row = Faq::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.faq.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return JsonResponse
     */
    public function getPhotoalbum(): JsonResponse
    {
        $row = Photoalbum::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.photoalbum.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('name', function ($row) {
                $title = $row->name;
                $title .= '<br><br><a href="' . URL::route('cp.photos.index', ['photoalbum_id' => $row->id]) . '">Фото</a>';

                return $title;
            })
            ->rawColumns(['actions', 'name'])->make(true);
    }

    /**
     * @param int $photoalbum_id
     * @return JsonResponse
     */
    public function getPhotos(int $photoalbum_id): JsonResponse
    {
        $row = Photos::where('photoalbum_id', $photoalbum_id);

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {

                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.photos.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('thumbnail', function ($row) {
                return '<img  height="150" src="' . url($row->getThumbnailUrl()) . '" alt="" loading="lazy">';
            })
            ->rawColumns(['actions', 'thumbnail'])->make(true);
    }

    /**
     * @param int $product_id
     * @return JsonResponse
     */
    public function getDetectedGases(int $product_id): JsonResponse
    {
        $row = DetectedGases::where('product_id', $product_id);

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.detected_gases.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['actions'])->make(true);
    }
}
