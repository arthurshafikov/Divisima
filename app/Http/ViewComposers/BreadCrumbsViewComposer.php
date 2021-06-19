<?php

namespace App\Http\ViewComposers;

use App\Includes\BreadCrumbs;
use Illuminate\Contracts\View\View;

class BreadCrumbsViewComposer
{

    public function compose(View $view)
    {
        $breadcrumbs = BreadCrumbs::getBreadCrumbs();
        $view->with('breadcrumbs', $breadcrumbs);
    }
}
