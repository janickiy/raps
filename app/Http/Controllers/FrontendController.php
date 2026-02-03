<?php

namespace App\Http\Controllers;


use App\Repositories\CatalogRepository;
use App\Repositories\ProductsRepository;
use App\Repositories\SeoRepository;
use App\Services\RequestsService;
use App\Helpers\SettingsHelper;
use App\Http\Requests\Frontend\SendApplicationRequest;
use App\Models\{Catalog, Faq, Pages, PhotoAlbum, ProductParametersCategory, Products, Requests, Services};
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use File;
use Mail;

class FrontendController extends Controller
{
    public function __construct(
        private ProductsRepository $productsRepository,
        private SeoRepository      $seoRepository,
        private RequestsService    $requestsService,
        private CatalogRepository  $catalogRepository,
    )
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $page = Pages::where('main', 1)->published()->first();

        if (!$page) abort(404);

        $title = $page->title ?? 'Главная';
        $meta_description = $page->meta_description ?? '';
        $meta_keywords = $page->meta_keywords ?? '';
        $meta_title = $page->meta_title ?? '';
        $seo_url_canonical = $page->seo_url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;

        return view('frontend.index', compact(
                'page',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'seo_url_canonical',
                'h1')
        )->with('title', $title);
    }

    /**
     * @return View
     */
    public function contact(): View
    {
        $seo = $this->seoRepository->getSeo('frontend.contact', 'Конвертер единиц измерения концентрации');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $phones = [];
        $phoneList = SettingsHelper::getSetting('PHONE');

        if ($phoneList) {
            $phones = explode(',', $phoneList);
        }

        return view('frontend.contact', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'phones',
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', 'Обратная связь');
    }

    /**
     * @param string|null $slug
     * @return View
     */
    public function catalog(?string $slug = null): View
    {
        $seo = $this->seoRepository->getSeo('frontend.catalog', 'Каталог');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $pathway = '';
        $products = null;

        if ($slug) {
            $catalog = Catalog::where('slug', $slug)->first();

            if (!$catalog) abort(404);

            $pathway = $this->catalogRepository->topbarMenu($catalog->id);

            $catalogsIds = Catalog::getAllChildren($catalog->id);
            $catalogsIds[] = $catalog->id;

            $products = $this->productsRepository->getProducts($catalogsIds, 15);

            $title = $catalog->name;
            $meta_description = $catalog->meta_description;
            $meta_keywords = $catalog->meta_keywords;
            $meta_title = $catalog->meta_title;
            $seo_url_canonical = $catalog->seo_url_canonical;
        } else {
            $catalog = null;
        }

        $productIds = $this->productsRepository->viewedProducts();

        return view('frontend.catalog', compact(
                'productIds',
                'pathway',
                'products',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'slug',
                'catalog',
                'seo_url_canonical')
        )->with('title', $title);
    }

    /**
     * @param string $slug
     * @param Request $request
     * @return View
     */
    public function detected_gases(Request $request, string $slug): View
    {
        $product = Products::where('slug', $slug)->published()->first();

        if (!$product) abort(404);

        $title = $product->title;
        $meta_description = $product->meta_description ?? '';
        $meta_keywords = $product->meta_keywords ?? '';
        $meta_title = $product->meta_title ?? '';
        $seo_url_canonical = $product->seo_url_canonical ?? '';
        $h1 = $product->h1 ?? $title;

        $faq = Faq::all();

        $pathway = $this->catalogRepository->topbarMenu($product->catalog_id);
        $productIds = $this->productsRepository->setViewed($request, $product->id);

        return view('frontend.detected_gases', compact(
                'product',
                'slug',
                'faq',
                'productIds',
                'pathway',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical')
        )->with('title', $title);
    }

    /**
     * @param string $slug
     * @param Request $request
     * @return View
     */
    public function product(Request $request, string $slug): View
    {
        $product = Products::where('slug', $slug)->published()->first();

        if (!$product) abort(404);

        $title = $product->title;
        $meta_description = $product->meta_description ?? '';
        $meta_keywords = $product->meta_keywords ?? '';
        $meta_title = $product->meta_title ?? '';
        $seo_url_canonical = $product->seo_url_canonical ?? '';
        $h1 = $product->h1 ?? $title;
        $productParametersCategory = ProductParametersCategory::all();

        $faq = Faq::all();

        $pathway = $this->catalogRepository->topbarMenu($product->catalog_id);
        $productIds = $this->productsRepository->setViewed($request, $product->id);

        return view('frontend.product', compact(
                'product',
                'productParametersCategory',
                'slug',
                'pathway',
                'productIds',
                'faq',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical')
        )->with('title', $title);
    }

    /**
     * @return View
     */
    public function servicesListing(): View
    {
        $seo = $this->seoRepository->getSeo('frontend.services_listing', 'Услуги компании');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $services = Services::orderBy('title')->published()->get();
        $productIds = $this->productsRepository->viewedProducts();

        return view('frontend.services_listing', compact(
                'services',
                'productIds',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'seo_url_canonical',
                'h1')
        )->with('title', $title);
    }

    /**
     * @param string $slug
     * @return View
     */
    public function service(string $slug): View
    {
        $service = Services::where('slug', $slug)->published()->first();

        if (!$service) abort(404);

        $seo = $this->seoRepository->getSeo('frontend.services_listing', 'Услуги компании');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $productIds = $this->productsRepository->viewedProducts();

        return view('frontend.service', compact(
                'service',
                'productIds',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'seo_url_canonical',
                'h1')
        )->with('title', $title);
    }

    /**
     * @return View
     */
    public function about(): View
    {
        $seo = $this->seoRepository->getSeo('frontend.about', 'О компании');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $page = Pages::where('slug', 'about')->published()->first();

        if (!$page) abort(404);

        return view('frontend.about', compact(
                'page',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical')
        )->with('title', $title);
    }

    /**
     * @param string $slug
     * @return View
     */
    public function page(string $slug): View
    {
        $page = Pages::where('slug', $slug)->published()->first();

        if (!$page) abort(404);

        $title = $page->title ?? 'Главная страница';
        $meta_description = $page->meta_description ?? '';
        $meta_keywords = $page->meta_keywords ?? '';
        $meta_title = $page->meta_title ?? '';
        $seo_url_canonical = $page->seo_url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;

        return view('frontend.page', compact(
                'page',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical')
        )->with('title', $title);
    }

    /**
     * @return View
     */
    public function application(): View
    {
        $seo = $this->seoRepository->getSeo('frontend.application', 'Оформление заявки');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        return view('frontend.application', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical',
                'title'
            )
        )->with('title', $title);
    }

    /**
     * @param SendApplicationRequest $request
     * @return RedirectResponse
     */
    public function sendApplication(SendApplicationRequest $request): RedirectResponse
    {
        try {
            $filename = $this->requestsService->sendApplication($request);

            Requests::create(array_merge($request->all(), ['path' => $filename, 'ip' => $request->ip()]));

        } catch (\Exception $e) {
            report($e);
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Спасибо, что обратились в компанию RAPS!<br>Ваш файл отправлен.<br>Менеджер свяжется с Вами в ближайшее время.');
    }

    /**
     * @param string $slug
     * @return View
     */
    public function album(string $slug): View
    {
        $album = PhotoAlbum::where('slug', $slug)->first();

        if (!$album) abort(404);

        $title = $album->name ?? '';
        $meta_description = $album->meta_description ?? '';
        $meta_keywords = $album->meta_keywords ?? '';
        $meta_title = $album->meta_title ?? '';
        $seo_url_canonical = $album->seo_url_canonical ?? '';
        $h1 = $seo->h1 ?? $title;

        return view('frontend.album', compact(
                'album',
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical')
        )->with('title', $title);
    }
}
