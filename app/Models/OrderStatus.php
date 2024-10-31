<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class OrderStatus extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    const ID = 'id';
    const UUID = 'uuid';
    const NAME = 'name';

    const CREATED_AT = 'created_at';
    const DELETED_AT = 'deleted_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'order_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::UUID,
        self::NAME,
    ];

    protected $hidden = [
        self::CREATED_AT,
        self::DELETED_AT,
        self::UPDATED_AT,
    ];
}
