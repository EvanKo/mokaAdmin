<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
      protected $fillable = array(
  'moka'
  ,'price'
  ,'type'
  ,'content'
  ,'img'
  ,'imgnum'
);
}
