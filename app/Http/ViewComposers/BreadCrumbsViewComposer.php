<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Includes\BreadCrumbs;

class BreadCrumbsViewComposer
{

    public function compose(View $view)
    {
        $breadcrumbs = BreadCrumbs::getBreadCrumbs();
        $view->with('breadcrumbs',$breadcrumbs);
    }

    
}
