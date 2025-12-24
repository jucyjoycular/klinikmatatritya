<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Doctor extends Model
{
    use HasFactory;
    protected $fillable = ['name','specialty','photo','phone','bio'];
    public function schedulesc(){ return $this->hasMany(Schedule::class); }

    public function schedules()
{
    return $this->hasMany(DoctorSchedule::class);
}
}
