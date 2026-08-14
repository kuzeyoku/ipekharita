<?php

namespace App\Http\Controllers\Admin;

use App\Services\ImageService;
use App\Http\Requests\Admin\Media\UploadEditorMediaRequest;
use Illuminate\Http\JsonResponse;

class EditorMediaController extends BaseAdminController
{
    /**
     * Upload image from TinyMCE editor and return JSON location.
     */
    public function upload(UploadEditorMediaRequest $request): JsonResponse
    {
        if ($request->hasFile('file')) {
            $path = ImageService::uploadEditorImage($request->file('file'));
            return response()->json([
                'location' => asset($path),
            ]);
        }

        return response()->json(['error' => 'Görsel yüklenemedi.'], 400);
    }
}
