<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = "Cart";

    protected $primarykey = 'id';

    protected $fillable=[
        'id',
        'cart_id',
        'items',
        'user_id',
    ];


public function Transactions(){
    return $this->hasMany(Transaction::class);
}

public function Users(){
    return $this->belongsTo(User::class);
}

}
