<?php

namespace App\Helpers;

use Harimayco\Menu\Models\Menus;
use Illuminate\Support\Facades\Cache;

class MenuHelper
{
    /**
     * @return array
     */
    public static function getMenuList(): array
    {
        if (Cache::has('menu')) {
            return Cache::get('menu');
        } else {
            $menuServices = Menus::where('name', 'services')->with('items')->first();
            $menuAbout = Menus::where('name', 'about')->with('items')->first();

            $menu = [
                'about' => $menuAbout?->items->toArray(),
                'services' => $menuServices?->items->toArray(),
            ];

            Cache::put('menu', $menu);

            return $menu;
        }
    }
}
