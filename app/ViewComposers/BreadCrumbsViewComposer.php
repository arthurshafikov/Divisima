<?php

namespace App\ViewComposers;

use App\Includes\BreadCrumbs;
use Illuminate\Contracts\View\View;

class BreadCrumbsViewComposer
{
    public function compose(View $view)
    {
        $view->with('breadcrumbs', BreadCrumbs::getBreadCrumbs());
    }
}
