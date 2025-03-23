<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    const STATUS_ID = 'status_id';
    const CUSTOMER_ID = 'customer_id';
    const UUID = 'uuid';
    const ID = 'id';
    const CODE = 'code';
    const ORDERED_AT = 'ordered_at';
    const PRICE = 'price';

    const CREATED_AT = 'created_at';
    const DELETED_AT = 'deleted_at';
    const UPDATED_AT = 'updated_at';

    const STATUS = 'status';

    protected $table = 'order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::ID,
        self::UUID,
        self::ORDERED_AT,
        self::CODE,
        self::CUSTOMER_ID,
        self::STATUS_ID,
        self::PRICE,
    ];

    protected $hidden = [
        self::CREATED_AT,
        self::DELETED_AT,
        self::UPDATED_AT,
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', OrderProduct::ORDER_ID, OrderProduct::PRODUCT_ID);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
