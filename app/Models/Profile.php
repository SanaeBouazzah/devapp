<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'name',
      'email',
      'image',
      'password',
      'bio'
    ];

     function getImageAttribute($value){
      return $value??'images/inconnu.jpeg';
    }


}
