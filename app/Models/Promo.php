<?php

namespace App\Models;

use App\Traits\HandlesMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;
    use HandlesMedia;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'price',
        'start_date',
        'end_date',
    ];

    public function mediaUsage(){
        return $this->morphOne(MediaUsage::class, 'model');
    }

    public function media(){
        return $this->mediaUsage()->media();
    }
}
