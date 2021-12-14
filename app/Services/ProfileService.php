<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function uploadAvatar(string $file): array
    {
        $user = Auth::user();
        $image = Image::create([
            'src' => $file,
        ]);
        $user->profile()->update([
            'image_id' => $image->id,
        ]);

        return [
            'text'  => $file,
        ];
    }

    public function updateProfileInfo(array $validated): void
    {
        $user = Auth::user();
        $user->profile()->update($validated);
    }
}
