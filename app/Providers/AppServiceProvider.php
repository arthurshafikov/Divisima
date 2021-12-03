<?php

namespace App\Providers;

use App\Http\ViewComposers\Admin\AdminMenuComposer;
use App\Http\ViewComposers\Admin\ChartsComposer;
use App\Http\ViewComposers\Admin\MediaComposer;
use App\Http\ViewComposers\BreadCrumbsViewComposer;
use App\Http\ViewComposers\FooterViewComposer;
use App\Http\ViewComposers\HeaderViewComposer;
use App\Http\ViewComposers\RecentlyViewed;
use App\Http\ViewComposers\ShopViewComposer;
use App\Http\ViewComposers\SliderViewComposer;
use App\Http\ViewComposers\TopSellingViewComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }

    public function boot()
    {
        Paginator::defaultView('vendor.pagination.bootstrap-4');

        view()->share('defaultAvatar', '/img/default-avatar.png');

        // shop composers
        view()->composer('parts.header.header', HeaderViewComposer::class);
        view()->composer('parts.slider', SliderViewComposer::class);
        view()->composer('shop', ShopViewComposer::class);
        view()->composer('parts.breadcrumbs', BreadCrumbsViewComposer::class);
        view()->composer('parts.product.recently-viewed', RecentlyViewed::class);
        view()->composer('parts.footer.footer', FooterViewComposer::class);
        view()->composer('parts.product.top-selling', TopSellingViewComposer::class);

        // admin composers
        view()->composer('admin.parts.breadcrumbs', BreadCrumbsViewComposer::class);
        view()->composer('admin.vendor.admin', AdminMenuComposer::class);
        view()->composer('admin.parts.media', MediaComposer::class);
        view()->composer('admin.parts.charts', ChartsComposer::class);
    }
}
