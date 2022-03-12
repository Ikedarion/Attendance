<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'quantity'
    ];

    public function scopeUserSearch($query)
    {
        $query->where('user_id', Auth::id());
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
