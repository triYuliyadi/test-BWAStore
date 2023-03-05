<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Transaction;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transactions_id',
        'products_id',
        'price',
        'shipping_status',
        'resi',
        'code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //
    ];

    // Relasi ke tabel transaction dan product
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'products_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transactions_id');
    }
}
