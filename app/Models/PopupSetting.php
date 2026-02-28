<?php

namespace App\Models;

use App\Traits\HandlesMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopupSetting extends Model
{
     use HandlesMedia;

     protected $fillable = ['image', 'is_active'];

     public function mediaUsage(){
        return $this->morphOne(MediaUsage::class, 'model');
     }

     public function media(){
        return $this->mediaUsage()->media();
     }
}
