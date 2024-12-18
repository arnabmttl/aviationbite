<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

// Repositories
use App\Repositories\FooterRepository;
use App\Repositories\MenuItemRepository;
use App\Repositories\ThreadRepository;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * View creator to get menu and footer for all pages.
         * View creator code will be executed for frontend routes only.
         */
        if (!\Request::is('backend/*')) {
            View::creator('*', function($view) {
                $menuItems = (new MenuItemRepository)->getAllMenuItemsWithoutParent();
                $footer = (new FooterRepository)->getFirstFooter();
                $latestSixThreads = (new ThreadRepository)->getLatestUpdatedThreads(6);
                
                $view->with([
                    'menuItems' => $menuItems,
                    'footer' => $footer,
                    'latestSixThreads' => $latestSixThreads
                ]);
            });
        }
    }
}
