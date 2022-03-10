<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'start_time',
        'end_time'
    ];

    public function scopeUserSearch($query)
    {
        $query->where('user_id', Auth::id());
    }

    public function scopeTodaySearch($query)
    {
        $dt = new Carbon();
        $today = $dt->toDateString();

        $query->where('date', $today);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
