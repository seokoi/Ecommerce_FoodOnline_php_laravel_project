<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'staff_id',
        'total',
        'phone',
        'address',
        'status',
        'cancellation_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Mối quan hệ với món ăn thông qua OrderItem
    public function foods()
    {
        return $this->hasManyThrough(Food::class, OrderItem::class);
    }

}