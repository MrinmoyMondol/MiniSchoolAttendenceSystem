<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attendence;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

     protected $fillable = ['name','student_id','class','section','photo'];

    public function attendances()
    {
        return $this->hasMany(Attendence::class);
    }
}
