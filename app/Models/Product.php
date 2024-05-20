<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'price',
        'is_active',
        'product_type_id',

    ];
    protected $hidden = [
        'product_type_id',
    ];

    /**
     * RELATIONS
     */
    public function images()
    {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }
    public function productType()
    {
        return $this->hasOne(ProductType::class, 'id', 'product_type_id');
    }

}
