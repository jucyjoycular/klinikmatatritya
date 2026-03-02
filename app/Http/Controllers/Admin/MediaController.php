<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->paginate(10);
        return view('admin.media.index', compact('media'));
    }

    public function list(): JsonResponse
    {
        $mediaList = Media::select('id', 'filename', 'filepath')->latest()->get();
        return response()->json($mediaList);
    }

    public function destroy(Request $request, $id)
    {
        $media = Media::with('usages.model')->findOrFail($id);

        // Jika masih dipakai dan belum force
        if ($media->usages->count() > 0 && !$request->boolean('force')) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Media ini digunakan di '.$media->usages->count().' fitur.',
                'usage_count' => $media->usages->count()
            ]);
        }

        DB::transaction(function () use ($media) {

            foreach ($media->usages as $usage) {

                $model = $usage->model;

                if ($model && isset($model->photo)) {
                    $model->photo = null;
                    $model->save();
                }

                $usage->delete();
            }

            // Hapus file fisik
            if ($media->filepath && Storage::disk('public')->exists($media->filepath)) {
                Storage::disk('public')->delete($media->filepath);
            }

            $media->delete();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Media berhasil dihapus.'
        ]);
    }

    public function usage($id): JsonResponse
    {
        $media = Media::with('usages.model')->findOrFail($id);

        if ($media->usages->count() === 0) {
            return response()->json([
                'status' => 'unused'
            ]);
        }

        $usageList = $media->usages->map(function ($usage) {
            return [
                'type' => class_basename($usage->model_type),
                'name' => $usage->model->name ?? $usage->model->title ?? 'Tanpa Nama'
            ];
        });

        return response()->json([
            'status' => 'used',
            'usage_count' => $media->usages->count(),
            'usage_list' => $usageList
        ]);
}

}
