<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

    protected $table    = 'orders';
    protected $guarded  = ['id'];
    protected $fillable = [
        'order_date',
        'invoice_no',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_contact',
        'customer_address',
        'total_price',
        'status'
    ];

    public const ORDER_STATUS = [
        'Pending',
        'Confirmed',
        'Processing',
        'Delivered',
        'Cancelled'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderFeedbacks()
    {
        return $this->hasMany(OrderFeedback::class);
    }
}
