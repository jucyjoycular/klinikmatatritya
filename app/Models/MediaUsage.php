<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaUsage extends Model
{
    use HasFactory;

    protected $fillable = ['media_id', 'model_id', 'model_type'];

    public function media(){
        return $this->belongsTo(Media::class);
    }

    public function model(){
        return $this->morphTo();
    }


}
