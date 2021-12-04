<?php

namespace App\Providers;

use App\ViewComposers\Admin\AdminMenuComposer;
use App\ViewComposers\Admin\ChartsComposer;
use App\ViewComposers\Admin\MediaComposer;
use App\ViewComposers\BreadCrumbsViewComposer;
use App\ViewComposers\FooterViewComposer;
use App\ViewComposers\HeaderViewComposer;
use App\ViewComposers\RecentlyViewed;
use App\ViewComposers\ShopViewComposer;
use App\ViewComposers\SliderViewComposer;
use App\ViewComposers\TopSellingViewComposer;
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
