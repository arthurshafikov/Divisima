<?php

namespace App\Http\Controllers;

use App\Models\Promocode;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    public function acceptPromocode(Request $request)
    {
        $promocode = Promocode::where('promocode', $request->promocode)->first();
        if ($promocode && $promocode->expired_at->isFuture()) {
            session(['promocode' => $promocode->discount]);
            return redirect()->back()->with('msg', __('promocode.applied'));
        }
        return redirect()->back()->with('err', 'Wrong promocode');
    }

    public function removePromocode()
    {
        request()->session()->forget('promocode');
        return redirect()->back()->with('msg', __('promocode.deleted'));
    }
}
