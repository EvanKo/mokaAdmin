<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Figure extends Model
{
	protected $table = 'Figures';
	protected $guarded = [];

	public function Role()
	{
		return $this->belongsTo(Role::class,'moka');
	}
}
