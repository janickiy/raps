<?php

namespace App\Http\Controllers;

use App\Models\{
    Catalog,
    Pages,
    Products,
    ProductParametersCategory,
    Seo
};
use App\Http\Request\Frontend\SendApplicationRequest;
use Harimayco\Menu\Models\Menus;
use App\Helpers\SettingsHelper;
use App\Mail\Notification;
use File;
use Mail;

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
        $h1 = $seo->h1 ?? $title;

        $menu_services = Menus::where('name', 'services')->with('items')->first();
        $menu_about = Menus::where('name', 'about')->with('items')->first();

        $menu = [
            'about' => $menu_about->items->toArray(),
            'services' => $menu_services->items->toArray(),
        ];

        $catalogs = Catalog::orderBy('name')->get();

        return view('frontend.index', compact(
                'catalogs',
                'page',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'seo_url_canonical',
                'h1',
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


        $catalogs = Catalog::orderBy('name')->get();

        return view('frontend.contact', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'menu',
                'catalogs',
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
        $h1 = $seo->h1 ?? $title;

        $catalogs = Catalog::orderBy('name')->get();

        return view('frontend.product_listing', compact(
                'catalog',
                'catalogs',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'seo_url_canonical',
                'h1',
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

        $catalogs = Catalog::orderBy('name')->get();

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        $seo = Seo::where('type', 'frontend.about')->first();

        $title = $seo->h1 ?? 'О компании';
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

        $catalogs = Catalog::orderBy('name')->get();

        return view('frontend.about', compact(
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

        $catalogs = Catalog::orderBy('name')->get();

        return view('frontend.index', compact(
                'page',
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function certificates()
    {
        $seo = Seo::where('type', 'frontend.application')->first();

        $title = $seo->title ?? 'Заявка на расчет проекта';
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

        $catalogs = Catalog::orderBy('name')->get();

        return view('frontend.application', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'menu',
                'catalogs',
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', 'Обратная связь');

    }

    public function application()
    {
        $seo = Seo::where('type', 'frontend.application')->first();

        $title = $seo->title ?? 'Заявка на расчет проекта';
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

        $catalogs = Catalog::orderBy('name')->get();

        return view('frontend.application', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'menu',
                'catalogs',
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', 'Оформление заявки');
    }

    public function sendApplication(SendApplicationRequest $request)
    {
        $path = public_path('uploads');
        $attachment = $request->file('attachment');

        $name = time() . '.' . $attachment->getClientOriginalExtension();;

        // create folder
        if (!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        $attachment->move($path, $name);
        $filename = $path . '/' . $name;

        try {

            Mail::to(explode(",", SettingsHelper::getSetting('EMAIL_NOTIFY')))->send(new Notification($filename));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Спасибо, что обратились в компанию RAPS!<br>Ваш файл отправлен.<br>Менеджер свяжется с Вами в ближайшее время.');
    }


}
