<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'code', 'description', 
        'daily_price', 'status', 'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function rentalItems()
    {
        return $this->hasMany(RentalItem::class);
    }
}