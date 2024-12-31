<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use League\Glide\Responses\SymfonyResponseFactory;
use League\Glide\ServerFactory;

class ImageController extends Controller
{
    public function index()
    {
        return response()->json(Image::paginate(12));
    }

    public function show(string $path)
    {
        $server = ServerFactory::create([
            'response' => new SymfonyResponseFactory(),
            'source' => storage_path('/app/private/uploads'),
            'cache' => storage_path('/app/private/cache'),
        ]);

        return $server->getImageResponse($path, $_GET);
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');
        $path = $file->store('uploads', 'local');

        $image = Image::create([
            'url' => asset('/api/storage/' . $path),
            'path' => $path,
            'type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'name' => $file->getClientOriginalName(),
        ]);

        if (!$image) {
            return response()->json([
                'message' => 'File upload failed',
                'data' => null,
                'success' => false,
            ], 400);
        }

        return response()->json([
            'message' => 'File uploaded',
            'data' => $image,
            'success' => true,
        ]);
    }

    public function destroy(string $id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json([
                'message' => 'Image not found',
                'data' => null,
                'success' => false,
            ], 404);
        }

        $image->delete();

        return response(status: 204);
    }
}
