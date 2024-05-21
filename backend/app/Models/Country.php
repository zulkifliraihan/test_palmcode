<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capital',
        'iso2',
        'iso3',
        'phone_code',
        'currency',
        'flag'
    ];

    public function bookings() : HasMany {
        return $this->hasMany(Booking::class);
    }
}
