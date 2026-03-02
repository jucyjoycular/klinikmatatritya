<?php

namespace App\Traits;

use App\Models\Media;
use App\Models\MediaUsage;

trait HandlesMedia
{
    // Untuk upload file baru
    public function attachMedia($model, $file)
    {
        $hash = md5_file($file->getRealPath());

        $media = Media::firstOrCreate(
            ['hash' => $hash],
            [
                'filename' => $file->getClientOriginalName(),
                'filepath' => $file->store('uploads','public')
            ]
        );

        $this->syncMediaUsage($model, $media->id);
    }

    // Untuk upload dari media library
    public function attachExistingMedia($model, $mediaId)
    {
        $this->syncMediaUsage($model, $mediaId);
    }

    // Helper biar tidak duplikat logic
    protected function syncMediaUsage($model, $mediaId)
    {
        MediaUsage::updateOrCreate(
            [
                'model_type' => get_class($model),
                'model_id'   => $model->id
            ],
            [
                'media_id'   => $mediaId
            ]
        );
    }
}