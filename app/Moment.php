<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moment extends Model
{
      protected $fillable = array('moka','content','img','imgnum','view','area');
	  public function Role()
	  {
		  return $this->belongsTo(Role::class,'moka');
	  }
}
