<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function uploadAvatar($file): array
    {
        $user = Auth::user();
        $res = [
            'error' => false,
            'text'  => '',
        ];
        $image = Image::create([
            'img' => $file,
        ]);
        $user->profile()->update([
            'avatar' => $image->id,
        ]);
        $res['text'] = $file;

        return $res;
    }

    public function updateProfileInfo(array $validated)
    {
        $user = Auth::user();
        $user->profile()->update($validated);
    }
}
