<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory, Notifiable;

    const NAME = 'name';
    const EMAIL = 'email';
    const UUID = 'uuid';
    const ID = 'id';
    const CPF = 'cpf';
    const CUSTOMER_TYPE = 'type';

    const CREATED_AT = 'created_at';
    const DELETED_AT = 'deleted_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::ID,
        self::NAME,
        self::EMAIL,
        self::CPF,
        self::CUSTOMER_TYPE,
        self::UUID,
    ];

    protected $hidden = [
        self::CREATED_AT,
        self::DELETED_AT,
        self::UPDATED_AT,
    ];

}
