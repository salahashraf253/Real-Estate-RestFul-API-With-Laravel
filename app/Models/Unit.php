<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'bedrooms',
        'bathrooms',
        'city',
        'description',
        'price',
        'type',
        'location',
        'size',
        'rooms',
        'bathrooms',
        'image',
        'is_sold',
    ];

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function markAsSold(): void
    {
        $this->is_sold = true;

        $this->save();
    }
}
