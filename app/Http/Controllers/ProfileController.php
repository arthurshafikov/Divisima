<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Requests\ProfileInfoRequest;
use App\Models\Image;
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

    public function uploadAvatar(ImageRequest $request)
    {
        $user = Auth::user();
        $res = [
            'error' => false,
            'text'  => '',
        ];
        $request->file('avatar');
        $file = $request->avatar->store('avatars');
        $image = Image::create([
            'img' => $file,
        ]);
        $user->profile->avatar = $image->id;
        $user->profile->save();
        $res['text'] = $file;

        return response()->json($res);
    }

    public function changeProfile(ProfileInfoRequest $request)
    {
        $user = Auth::user();
        $user->profile()->update($request->except('_token'));
        return;
    }
}
