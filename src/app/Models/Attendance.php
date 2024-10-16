<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'clock_in_time', 'clock_out_time', 'total_break_time'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function break_times()
    {
        return $this->hasMany(BreakTime::class);
    }
}


