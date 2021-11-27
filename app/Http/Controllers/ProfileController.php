<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\ProfileInfoRequest;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function account()
    {
        $user = Auth::user();

        return view('pages.account')->with([
            'title' => 'Your account',
            'profile' => $user->profile,
            'orders' => $user->orders,
        ]);
    }

    public function uploadAvatar(ImageRequest $request): JsonResponse
    {
        $request->file('avatar');
        $file = $request->avatar->store('avatars');

        return response()->json(app(ProfileService::class)->uploadAvatar($file));
    }

    public function changeProfile(ProfileInfoRequest $request)
    {
        app(ProfileService::class)->updateProfileInfo($request->validated());
    }
}
