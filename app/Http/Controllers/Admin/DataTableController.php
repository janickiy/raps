<?php

namespace App\Http\Controllers\Admin;

use App\Models\{
    Catalog,
    Pages,
    ProductDocuments,
    ProductParameters,
    ProductParametersCategory,
    ProductPhotos,
    Products,
    ServicesCatalog,
    Settings,
    Seo,
    Services,
    User};
use Illuminate\Support\Facades\Auth;
use DataTables;
use URL;

class DataTableController extends Controller
{
    /**
     * @return mixed
     */
    public function getUsers()
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
     * @return mixed
     */
    public function getServicesCatalog()
    {
        $row = ServicesCatalog::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.services_catalog.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('image', function ($row) {
                return '<img  height="150" src="' . url($row->getImage()) . '" alt="" loading="lazy">';
            })
            ->rawColumns(['actions', 'image'])->make(true);
    }

    /**
     * @return mixed
     */
    public function getServices()
    {
        $row = Services::selectRaw('services.id,services.title,services.catalog_id,services.slug,services.created_at,services.description,services_catalog.name AS services_catalog')
            ->leftJoin('catalog', 'catalog.id', '=', 'products.catalog_id')
            ->groupBy('services_catalog.name')
            ->groupBy('services.id')
            ->groupBy('services.title')
            ->groupBy('services.catalog_id')
            ->groupBy('services.slug')
            ->groupBy('services.description')
            ->groupBy('services.created_at')
            ->groupBy('services.description');

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary" href="' . URL::route('cp.services.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->editColumn('thumbnail', function ($row) {
                $services = Services::find($row->id);

                return '<img  height="150" src="' . url($services->getImage()) . '" alt="" loading="lazy">';
            })
            ->rawColumns(['actions', 'title', 'thumbnail'])->make(true);
    }


    /**
     * @return mixed
     */
    public function getPages()
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
     * @return mixed
     */
    public function getFeedback()
    {
        $row = Feedback::query();

        return Datatables::of($row)
            ->make(true);
    }

    /**
     * @return mixed
     */
    public function getSettings()
    {
        $row = Settings::query();

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.settings.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @return mixed
     */
    public function getSeo()
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
     * @return mixed
     */
    public function getCatalog()
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
     * @return mixed
     */
    public function getProducts()
    {
        $row = Products::selectRaw('products.id,products.title,products.catalog_id,products.slug,products.created_at,products.description,catalog.name AS catalog')
            ->leftJoin('catalog', 'catalog.id', '=', 'products.catalog_id')
            ->groupBy('catalog.name')
            ->groupBy('products.id')
            ->groupBy('products.title')
            ->groupBy('products.catalog_id')
            ->groupBy('products.slug')
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
                $title .= '<br><br><a href="' . URL::route('cp.product_photos.index', ['product_id' => $row->id]) . '">Фото</a>';
                $title .= '<br><a href="' . URL::route('cp.product_documents.index', ['product_id' => $row->id]) . '">Документы</a>';
                $title .= '<br><a href="' . URL::route('cp.product_parameters.index', ['product_id' => $row->id]) . '">Характеристики</a>';

                return $title;
            })
            ->editColumn('thumbnail', function ($row) {
                $product = Products::find($row->id);

                return '<img  height="150" src="' . url($product->getThumbnailUrl()) . '" alt="" loading="lazy">';
            })
            ->rawColumns(['actions', 'title', 'thumbnail'])->make(true);
    }

    /**
     * @param int $product_id
     * @return mixed
     */
    public function getPhotos(int $product_id)
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
     * @return mixed
     */
    public function getProductParameters(int $product_id)
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
                return $row->category ? $row->category:'Разное';
            })
            ->rawColumns(['actions'])->make(true);
    }

    /**
     * @param int $product_id
     * @return mixed
     */
    public function getDocuments(int $product_id)
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
     * @return mixed
     */
    public function getProductParametersCategory()
    {
        $row = ProductParametersCategory::query();;

        return Datatables::of($row)
            ->addColumn('actions', function ($row) {
                $editBtn = '<a title="редактировать" class="btn btn-xs btn-primary"  href="' . URL::route('cp.product_parameters_category.edit', ['id' => $row->id]) . '"><span  class="fa fa-edit"></span></a> &nbsp;';
                $deleteBtn = '<a title="удалить" class="btn btn-xs btn-danger deleteRow" id="' . $row->id . '"><span class="fa fa-remove"></span></a>';

                return '<div class="nobr"> ' . $editBtn . $deleteBtn . '</div>';
            })
            ->rawColumns(['actions'])->make(true);
    }

}
