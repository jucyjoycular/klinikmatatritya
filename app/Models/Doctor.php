<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = ['name','specialty','photo','phone','bio','education_level','education_history','special_training','competence','research_publications'];

    public function schedules(){
        return $this->hasMany(DoctorSchedule::class);
    }

    public function mediaUsage(){
        return $this->morphOne(MediaUsage::class, 'model');
    }

    public function media(){
        return $this->mediaUsage()->media();
    }

}