<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    const NAME = 'name';
    const DESCRIPTION = 'description';
    const PRICE = 'price';
    const UUID = 'uuid';
    const ID = 'id';
    const IMAGE_URI = 'image_uri';
    const CATEGORY_ID = 'category_id';

    const CREATED_AT = 'created_at';
    const DELETED_AT = 'deleted_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::ID,
        self::NAME,
        self::PRICE,
        self::IMAGE_URI,
        self::CATEGORY_ID,
        self::DESCRIPTION,
        self::UUID,
    ];

    protected $hidden = [
        self::CREATED_AT,
        self::DELETED_AT,
        self::UPDATED_AT,
    ];

    protected $with = [
        'category'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
