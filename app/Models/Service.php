<?php
namespace App\Models;
use App\Traits\HandlesMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    use HandlesMedia;

    protected $fillable = ['title','slug','excerpt','content','image'];

    public function mediaUsage(){
        return $this->morphOne(MediaUsage::class, 'model');
    }

    public function media(){
        return $this->mediaUsage()->media();
    }
}
