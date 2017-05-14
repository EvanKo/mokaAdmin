<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auths extends Model
{
	protected $table = 'Auths';
	protected $guarded = [];

	public function Role()
	{
		return $this->belongsTo(Role::class,'moka');
	}
}
