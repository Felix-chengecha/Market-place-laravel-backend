<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $table="Transactions";

    protected $primarykey="id";

    protected $fillable=[
        'id',
        'cart_id',
        'total',
        'user_id',
        'mpesa_trans_id',
        'pay_phone_no',
        'status',
    ];

    public function Cart(){
        return $this->belongsTo(Cart::class);

    }
}
