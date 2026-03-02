<?php

namespace App\Models;

use App\Models\MediaUsage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'filepath', 'hash'];

    public function usages(){
        return $this->hasMany(MediaUsage::class);
    }

    public function isUsed(){
        return $this->usages()->exists();
    }

    protected static function booted()
    {
        static::deleting(function ($media) {
            // Hapus file dari storage
            if (Storage::disk('public')->exists($media->filepath)) {
                Storage::disk('public')->delete($media->filepath);
            }

            $media->usages()->delete();
        });
    }
}
