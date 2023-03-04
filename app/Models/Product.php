<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'filling_id',
        'slug',
        'name',
        'image',
        'intro_text',
        'description',
        'published',
        'article',
        'price_up',
        'price_after',
        'type_products',
        'coverage',
        'weight_photo',
        'number_tiers',
        'congratulatory_signature',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function filling()
    {
//        return $this->belongsTo(Filling::class, 'filling_id');
        return $this->belongsTo(Filling::class , 'filling_id');
    }


    public function meta()
    {
        return $this->belongsTo(SeoMeta::class, 'meta_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }



}
