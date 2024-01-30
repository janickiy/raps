<?php

namespace App\Exceptions;

use App\Models\Catalog;
use Harimayco\Menu\Models\Menus;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            if ($exception->getStatusCode() == 404) {
                $menu_services = Menus::where('name', 'services')->with('items')->first();
                $menu_about = Menus::where('name', 'about')->with('items')->first();

                $menu = [
                    'about' => $menu_about->items->toArray(),
                    'services' => $menu_services->items->toArray(),
                ];

                $catalogs = Catalog::orderBy('name')->get();

                return response()->view('errors.404', [
                    'menu' => $menu,
                    'catalogs' => $catalogs
                ], 404);
            }
        }
        return parent::render($request, $exception);
    }
}
