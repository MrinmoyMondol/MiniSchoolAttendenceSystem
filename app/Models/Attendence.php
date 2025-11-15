<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Student;

class Attendence extends Model
{
    use HasFactory;
    protected $fillable = ['student_id','date','status','note','recorded_by'];

    protected $dates = ['date'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
