<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['facilities'];

    protected $casts = [
        'facilities' => 'array',
    ];

    public function bookings()
    {
        return $this->hasMany(User::class);
    }
}
