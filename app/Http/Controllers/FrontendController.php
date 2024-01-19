<?php

namespace App\Http\Controllers;

use App\Models\{
    Catalog,
    Pages,
    Products,
    ProductParametersCategory,
    Seo
};
use Harimayco\Menu\Models\Menus;

class FrontendController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $page = Pages::where('main', 1)->first();

        if (!$page) abort(404);

        $title = $page->title ?? 'Главная';
        $meta_description = $page->meta_description ?? '';
        $meta_keywords = $page->meta_keywords ?? '';
        $meta_title = $page->meta_title ?? '';
        $seo_url_canonical = $page->seo_url_canonical ?? '';

        $menu_services = Menus::where('name', 'services')->with('items')->first();
        $menu_about = Menus::where('name', 'about')->with('items')->first();

        $menu = [
            'about' => $menu_about->items->toArray(),
            'services' => $menu_services->items->toArray(),
        ];

        $catalogs = Catalog::inRandomOrder()->limit(4)->get();

        return view('frontend.index', compact(
                'catalogs',
                'page',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'seo_url_canonical',
                'menu')
        )->with('title', $title);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        $seo = Seo::where('type', 'frontend.contact')->first();

        $title = $seo->h1 ?? 'Конвертер единиц измерения концентрации';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;

        $menu_services = Menus::where('name', 'services')->with('items')->first();
        $menu_about = Menus::where('name', 'about')->with('items')->first();

        $menu = [
            'about' => $menu_about->items->toArray(),
            'services' => $menu_services->items->toArray(),
        ];


        return view('frontend.contact', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'menu',
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', 'Обратная связь');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function catalog()
    {
        $menu_services = Menus::where('name', 'services')->with('items')->first();
        $menu_about = Menus::where('name', 'about')->with('items')->first();

        $menu = [
            'about' => $menu_about->items->toArray(),
            'services' => $menu_services->items->toArray(),
        ];

        $seo = Seo::where('type', 'frontend.catalog')->first();

        $title = 'Каталог';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;

        $catalogs = Catalog::orderBy('name')->get();

        return view('frontend.catalog', compact(
                'catalogs',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical',
                'menu')
        )->with('title', $title);
    }

    /**
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productListing(string $slug)
    {
        $catalog = Catalog::where('slug', $slug)->first();

        if (!$catalog) abort(404);

        $menu_services = Menus::where('name', 'services')->with('items')->first();
        $menu_about = Menus::where('name', 'about')->with('items')->first();

        $menu = [
            'about' => $menu_about->items->toArray(),
            'services' => $menu_services->items->toArray(),
        ];

        $title = $catalog->name;
        $meta_description = $catalog->meta_description;
        $meta_keywords = $catalog->meta_keywords;
        $meta_title = $catalog->meta_title;
        $seo_url_canonical = $catalog->seo_url_canonical;

        return view('frontend.product_listing', compact(
                'catalog',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'seo_url_canonical',
                'menu')
        )->with('title', $title);

    }

    /**
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product(string $slug)
    {
        $product = Products::where('slug', $slug)->first();

        if (!$product) abort(404);

        $menu_services = Menus::where('name', 'services')->with('items')->first();
        $menu_about = Menus::where('name', 'about')->with('items')->first();

        $menu = [
            'about' => $menu_about->items->toArray(),
            'services' => $menu_services->items->toArray(),
        ];

        $title = $product->title;
        $meta_description = $product->meta_description ?? '';
        $meta_keywords = $product->meta_keywords ?? '';
        $meta_title = $product->meta_title ?? '';
        $seo_url_canonical = $product->seo_url_canonical ?? '';
        $h1 = $product->h1 ?? $title;

        $productParametersCategory = ProductParametersCategory::all();

        return view('frontend.product', compact(
                'product',
                'productParametersCategory',
                'slug',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical',
                'menu')
        )->with('title', $title);

    }

    /**
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function page(string $slug)
    {
        $page = Pages::where('slug', $slug)->first();

        if (!$page) abort(404);

        $title = $page->title ?? 'Главная страница';
        $meta_description = $page->meta_description ?? '';
        $meta_keywords = $page->meta_keywords ?? '';
        $meta_title = $page->meta_title ?? '';
        $seo_url_canonical = $page->seo_url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;

        $menu_services = Menus::where('name', 'services')->with('items')->first();
        $menu_about = Menus::where('name', 'about')->with('items')->first();

        $menu = [
            'about' => $menu_about->items->toArray(),
            'services' => $menu_services->items->toArray(),
        ];

        return view('frontend.index', compact(
                'page',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical',
                'menu')
        )->with('title', $title);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function certificates()
    {
        $seo = Seo::where('type', 'frontend.certificates')->first();


        $title = $seo->h1 ?? 'Сертификаты';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;

        $menu_services = Menus::where('name', 'services')->with('items')->first();
        $menu_about = Menus::where('name', 'about')->with('items')->first();

        $menu = [
            'about' => $menu_about->items->toArray(),
            'services' => $menu_services->items->toArray(),
        ];

        return view('frontend.certificates', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'menu',
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', 'Обратная связь');

    }

    public function application()
    {

    }

    public function sendApplication()
    {

    }


}
