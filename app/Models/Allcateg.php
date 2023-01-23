<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allcateg extends Model
{
    use HasFactory;

    protected $table='allcategs';

    protected $primarykey = 'id';

    protected $fillable= [
        'category',
        'etc'
    ];



    public function allproducts(){
        // return $this->belongs(Allproducts::class);

        return $this->hasMany(Allproducts::class);
    }


}
