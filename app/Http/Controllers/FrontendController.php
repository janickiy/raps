<?php

namespace App\Http\Controllers;

use App\Models\{Catalog, Pages, Products, ProductParametersCategory, Requests, Seo, Services, Faq};
use App\Http\Request\Frontend\SendApplicationRequest;
use Harimayco\Menu\Models\Menus;
use App\Helpers\SettingsHelper;
use App\Mail\Notification;
use File;
use Illuminate\Http\Request;
use Mail;

class FrontendController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $page = Pages::where('main', 1)->published()->first();

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
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function catalog(Request $request)
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

        if ($request->session()->has('productIds')) {
            $productIds = $request->session()->get('productIds');
        } else {
            $productIds = null;
        }




        return view('frontend.catalog', compact(
                'catalogs',
                'productIds',
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
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productListing(string $slug, Request $request)
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

        if ($request->session()->has('productIds')) {
            $productIds = $request->session()->get('productIds');
        } else {
            $productIds = null;
        }

        return view('frontend.product_listing', compact(
                'catalog',
                'catalogs',
                'productIds',
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
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function product(string $slug, Request $request)
    {
        $product = Products::where('slug', $slug)->published()->first();

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

        $faq = Faq::all();

        if ($request->session()->has('productIds')) {
            $productIds = $request->session()->get('productIds');
            array_push($productIds, $product->id);
            $productIds = array_unique($productIds);
            $request->session()->put(['productIds' => $productIds]);
        } else {
            $productIds = [$product->id];
            $request->session()->put(['productIds' => $productIds]);
        }

        return view('frontend.product', compact(
                'product',
                'productParametersCategory',
                'slug',
                'catalogs',
                'productIds',
                'faq',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical',
                'menu')
        )->with('title', $title);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function servicesListing(Request $request)
    {
        $menu_services = Menus::where('name', 'services')->with('items')->first();
        $menu_about = Menus::where('name', 'about')->with('items')->first();

        $menu = [
            'about' => $menu_about->items->toArray(),
            'services' => $menu_services->items->toArray(),
        ];

        $seo = Seo::where('type', 'frontend.services')->first();

        $title = $seo->h1 ?? 'Услуги компании';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;

        $catalogs = Catalog::orderBy('name')->get();
        $services = Services::orderBy('title')->published()->get();

        if ($request->session()->has('productIds')) {
            $productIds = $request->session()->get('productIds');
        } else {
            $productIds = null;
        }




        return view('frontend.services_listing', compact(
                'catalogs',
                'services',
                'productIds',
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
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function service(string $slug, Request $request)
    {
        $service = Services::where('slug', $slug)->published()->first();

        if (!$service) abort(404);

        $menu_services = Menus::where('name', 'services')->with('items')->first();
        $menu_about = Menus::where('name', 'about')->with('items')->first();

        $menu = [
            'about' => $menu_about->items->toArray(),
            'services' => $menu_services->items->toArray(),
        ];

        $seo = Seo::where('type', 'frontend.services')->first();

        $title = $service->title;
        $meta_description = $service->meta_description ?? '';
        $meta_keywords = $service->meta_keywords ?? '';
        $meta_title = $service->meta_title ?? '';
        $seo_url_canonical = $service->seo_url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;

        $catalogs = Catalog::orderBy('name')->get();

        if ($request->session()->has('productIds')) {
            $productIds = $request->session()->get('productIds');
        } else {
            $productIds = null;
        }

        return view('frontend.service', compact(
                'catalogs',
                'service',
                'productIds',
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
    public function about()
    {
        $seo = Seo::where('type', 'frontend.about')->first();

        $title = $seo->h1 ?? 'О компании';
        $meta_description = $seo->description ?? '';
        $meta_keywords = $seo->keyword ?? '';
        $meta_title = $seo->title ?? '';
        $seo_url_canonical = $seo->url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;

        $page = Pages::where('slug', 'about')->published()->first();

        if (!$page) abort(404);

        $menu_services = Menus::where('name', 'services')->with('items')->first();
        $menu_about = Menus::where('name', 'about')->with('items')->first();

        $menu = [
            'about' => $menu_about->items->toArray(),
            'services' => $menu_services->items->toArray(),
        ];

        $catalogs = Catalog::orderBy('name')->get();

        return view('frontend.about', compact(
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
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function page(string $slug)
    {
        $page = Pages::where('slug', $slug)->published()->first();

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

        return view('frontend.page', compact(
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

    /**
     * @param SendApplicationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendApplication(SendApplicationRequest $request)
    {
        $path = public_path('uploads/attachment');
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

            Requests::create(array_merge($request->all(), ['path' => $name, 'ip' => $request->ip()]));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Спасибо, что обратились в компанию RAPS!<br>Ваш файл отправлен.<br>Менеджер свяжется с Вами в ближайшее время.');
    }


}
