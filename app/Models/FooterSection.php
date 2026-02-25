<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSection extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'title', 'content', 'image'];

    public function items()
    {
        return $this->hasMany(FooterItem::class)->orderBy('id');
    }
}
