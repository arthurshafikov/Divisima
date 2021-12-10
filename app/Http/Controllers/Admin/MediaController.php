<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeleteImagesRequest;
use App\Http\Requests\Admin\LoadGalleryRequest;
use App\Http\Requests\MediaRequest;
use App\Services\Admin\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MediaController extends Controller
{
    public function loadGallery(LoadGalleryRequest $request): JsonResponse
    {
        $content = app(MediaService::class)->getGalleryImagesHtml($request->get('gallery'));

        return response()->json($content);
    }

    public function uploadImage(MediaRequest $request): JsonResponse
    {
        $content = app(MediaService::class)->uploadImages($request->file('image'));

        return response()->json($content);
    }

    public function deleteImages(DeleteImagesRequest $request): JsonResponse
    {
        $result = app(MediaService::class)->deleteImages($request->get('image_ids'));

        return response()->json($result);
    }

    public function loadMediaImages(): Response
    {
        $content = app(MediaService::class)->loadMediaImages();

        return response($content);
    }
}
