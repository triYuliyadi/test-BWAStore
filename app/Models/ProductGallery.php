<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductGallery extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'photos', 'products_id'
    ];

    protected $hidden =
    [
        
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
}
