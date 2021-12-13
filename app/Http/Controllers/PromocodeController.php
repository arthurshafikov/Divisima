<?php

namespace App\Http\Controllers;

use App\Models\Promocode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    public function acceptPromocode(Request $request): RedirectResponse
    {
        $promocode = Promocode::wherePromocode($request->input('promocode'))->first();
        if ($promocode && $promocode->expired_at->isFuture()) {
            session(['promocode' => $promocode->discount]);
            return redirect()->back()->with('msg', __('promocode.applied'));
        }

        return redirect()->back()->with('err', 'Wrong promocode');
    }

    public function removePromocode(): RedirectResponse
    {
        request()->session()->forget('promocode');

        return redirect()->back()->with('msg', __('promocode.deleted'));
    }
}
