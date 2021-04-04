<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
// use \Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // if ($this->app->environment('local', 'testing')) {
            // $this->app->register(DuskServiceProvider::class);
        // }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('vendor.pagination.bootstrap-4');

        view()->share('defaultAvatar', '/img/default-avatar.png');
        
        // shop composers
        view()->composer('parts.header.header', \App\Http\ViewComposers\HeaderViewComposer::class);
        view()->composer('parts.slider', \App\Http\ViewComposers\SliderViewComposer::class);
        view()->composer('shop', \App\Http\ViewComposers\ShopViewComposer::class);
        view()->composer('parts.breadcrumbs', \App\Http\ViewComposers\BreadCrumbsViewComposer::class);
        view()->composer('parts.product.recently-viewed', \App\Http\ViewComposers\RecentlyViewed::class);
        view()->composer('parts.footer.footer', \App\Http\ViewComposers\FooterViewComposer::class);
        view()->composer('parts.product.top-selling', \App\Http\ViewComposers\TopSellingViewComposer::class);

        // admin composers
        view()->composer('admin.parts.breadcrumbs', \App\Http\ViewComposers\BreadCrumbsViewComposer::class);
        view()->composer('admin.vendor.admin', \App\Http\ViewComposers\Admin\AdminMenuComposer::class);
        view()->composer('admin.parts.media', \App\Http\ViewComposers\Admin\MediaComposer::class);
        view()->composer('admin.parts.charts', \App\Http\ViewComposers\Admin\ChartsComposer::class);

    }
}
