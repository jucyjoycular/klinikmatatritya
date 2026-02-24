<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterItem extends Model
{
    use HasFactory;

    protected $fillable = ['footer_section_id', 'pemeriksaan', 'harga_normal', 'harga_promo', 'keterangan'];

    public function section()
    {
        return $this->belongsTo(FooterSection::class);
    }
}
