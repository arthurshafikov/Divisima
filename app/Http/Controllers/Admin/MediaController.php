<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaRequest;
use App\Models\Image;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function loadGallery(Request $request)
    {
        $images = $request->get('gallery');

        ob_start();
        $images = Image::whereIn('id', $images)->get();
        foreach ($images as $img) {
            echo view('admin.parts.gallery-image', [
                'img' => $img,
            ])->render();
        }
        return response()->json(ob_get_clean());
    }

    public function uploadImage(MediaRequest $request)
    {
        $files = $request->file('image');

        ob_start();
        foreach ($files as $file) {
            $path = $file->store('images');
            $img = Image::create([
                'img' => $path,
            ]);
            echo view('admin.parts.media-image', [
                'img' => $img,
            ])->render();
        }
        $res = ob_get_clean();

        return response()->json($res);
    }

    public function deleteImages(Request $request)
    {
        $imageIds = $request->ids;
        $res = Image::destroy($imageIds);

        return response()->json($res);
    }

    public function loadMediaImages()
    {
        $images = Image::orderBy('created_at', 'desc')->paginate(20);
        ob_start();
        foreach ($images as $img) {
            echo view('admin.parts.media-image', ['img' => $img])->render();
        }
        return ob_get_clean();
    }
}
