<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allproducts extends Model
{
    use HasFactory;

    protected $table='allproducts';

    protected $primarykey = 'id';

    protected $fillable=[
        'allcategs_id',
        'title',
        'price',
        'description',
        'image',
        'rate',
        'count'
    ];



    public function allcategs(){
        return $this->belongsTo(Allcateg::class);
    }
}
