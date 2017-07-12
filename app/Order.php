<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $table = 'Orders';
      protected $fillable = array(
  'moka'
  ,'price'
  ,'type'
  ,'content'
  ,'img'
  ,'imgnum'
);
	  public function Role()
	{
		return $this->belongsTo(Role::class,'moka');
	  }
}
