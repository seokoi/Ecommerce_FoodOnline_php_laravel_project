<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'status',
    ];
    public function category()
{
    return $this->belongsTo(Category::class);
}
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
