<?php

namespace App\Exceptions;

use App\Models\Catalog;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Harimayco\Menu\Models\Menus;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param $request
     * @param Throwable $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            if ($exception->getStatusCode() == 404) {

                $menu_services = Menus::where('name', 'services')->with('items')->first();
                $menu_about = Menus::where('name', 'about')->with('items')->first();

                $menu = [
                    'about' => $menu_about?->items->toArray(),
                    'services' => $menu_services?->items->toArray(),
                ];

                $catalogs = Catalog::query()->orderBy('name')->get();

                $catalogsList = [];

                if ($catalogs) {
                    foreach ($catalogs->toArray() as $catalog) {
                        $catalogsList[$catalog['parent_id']][$catalog['id']] = $catalog;
                    }
                }

                $catalogs = Catalog::orderBy('name')->get();

                return response()->view('errors.404', [
                    'menu' => $menu,
                    'catalogsList' => $catalogsList,
                    'catalogs' => $catalogs
                ], 404);
            }
        }
        return parent::render($request, $exception);
    }
}
