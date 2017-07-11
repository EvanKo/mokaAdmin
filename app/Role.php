<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	  protected $table = 'Roles';
      protected $fillable = array('tel','moka'
      ,'login'
      ,'level'
      ,'sex'
      ,'v'
	  ,'viptime'
      ,'fee'
      ,'role'
      ,'lastest'
      ,'fans'
      ,'idols'
      ,'name'
      ,'province'
      ,'city'
      ,'head'
      ,'bgimg'
      ,'password'
      ,'intro'
      ,'area');

	  public function mokas()
	  {
		  return $this->hasMany(Moka::class,'moka');
	  }
	  public function orders()
	  {
		  return $this->hasMany(Order::class,'moka');
	  }
	  public function payrecords()
	  {
		  return $this->hasMany(PayRecord::class,'moka');
	  }
	  public function moments()
	  {
		  return $this->hasMany(Moment::class,'moka');
	  }
	  public function fans()
	  {
		  return $this->hasMany(Moment::class,'idol');
	  }
	  public function figure()
	  {
		  return $this->hasOne(Figure::class,'moka');
	  }
	  public function auths()
	  {
		  return $this->hasOne(Auths::class,'moka');
	  }
	  public static function boot()
	{
    	parent::boot();

    	static::saving(function ($model) {

        dd($model->head);

   		});
	}
}
