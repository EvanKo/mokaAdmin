<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moka extends Model
{
	protected $table = 'Mokas';	

	public function Role()
	{
		return $this->belongsTo(Role::class,'moka');
	}
}
