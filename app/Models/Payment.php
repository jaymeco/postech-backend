<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    const STATUS = 'status';
    const ACTIVE = 'active';
    const DATE = 'date';
    const ORDER_UUID = 'order_uuid';
    const PAYMENT_ID = 'payment_id';

    const CREATED_AT = 'created_at';
    const DELETED_AT = 'deleted_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'payment';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::DATE,
        self::STATUS,
        self::ACTIVE,
        self::ORDER_UUID,
        self::PAYMENT_ID,
    ];

    protected $casts = [
        self::DATE => 'datetime'
    ];

    protected $hidden = [
        self::CREATED_AT,
        self::DELETED_AT,
        self::UPDATED_AT,
    ];
}
