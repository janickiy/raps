<?php

namespace App\Providers;

use App\Models\Catalog;
use App\Helpers\MenuHelper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function() {
            return base_path().'/public';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.frontend', function ($view){
            $view->with('menu', MenuHelper::getMenuList());
            $view->with('catalogsList', Catalog::getCatalogList());
            $view->with('catalogs', Catalog::orderBy('name')->where('parent_id', 0)->get());
        });
    }
}
