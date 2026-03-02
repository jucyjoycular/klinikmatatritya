<?php

namespace App\Models;

use App\Traits\HandlesMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSection extends Model
{
    use HandlesMedia;
    use HasFactory;

    protected $fillable = ['slug', 'title', 'content', 'image'];

    public function items()
    {
        return $this->hasMany(FooterItem::class)->orderBy('id');
    }

    public function mediaUsage(){
        return $this->morphOne(MediaUsage::class, 'model');
    }

    public function media(){
        return $this->mediaUsage()->media();
    }
}
