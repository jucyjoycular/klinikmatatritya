<?php

namespace App\Models;

use App\Traits\HandlesMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;
    use HandlesMedia;
    
    protected $fillable = [
        'title',
        'description',
        'background',
        'button_text',
        'button_link',
        'is_active'
    ];

    public function mediaUsage(){
        return $this->morphOne(MediaUsage::class, 'model');
    }

    public function media(){
        return $this->mediaUsage()->media();
    }
}