<?php
namespace App\Models;
use App\Traits\HandlesMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    use HandlesMedia;

    protected $fillable = ['title','slug','excerpt','content','image','published_at'];
    protected $dates = ['published_at'];

    public function mediaUsage(){
        return $this->morphOne(MediaUsage::class, 'model');
    }

    public function media(){
        return $this->mediaUsage()->media();
    }
}
