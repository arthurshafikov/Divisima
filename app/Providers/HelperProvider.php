<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperProvider extends ServiceProvider
{
    public function boot()
    {
        require_once app_path("Includes/helpers.php");
        require_once app_path("Includes/BreadCrumbs.php");
    }
}
