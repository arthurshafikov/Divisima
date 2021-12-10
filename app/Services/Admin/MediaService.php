<?php

namespace App\Services\Admin;

use App\Models\Image;

class MediaService
{
    public function getGalleryImagesHtml(array $images): string
    {
        ob_start();
        foreach (Image::whereIn('id', $images)->get() as $image) {
            echo view('admin.parts.gallery-image', [
                'img' => $image,
            ])->render();
        }

        return ob_get_clean();
    }

    public function uploadImages(array $images): string
    {
        ob_start();
        foreach ($images as $image) {
            $img = Image::create([
                'src' => $image->store('images'),
            ]);
            echo view('admin.parts.media-image', [
                'img' => $img,
            ])->render();
        }

        return ob_get_clean();
    }

    public function deleteImages(array $imageIds): int
    {
        return Image::destroy($imageIds);
    }

    public function loadMediaImages(): string
    {
        ob_start();
        foreach (Image::orderBy('created_at', 'desc')->paginate(20) as $img) {
            echo view('admin.parts.media-image', [
                'img' => $img,
            ])->render();
        }

        return ob_get_clean();
    }
}
