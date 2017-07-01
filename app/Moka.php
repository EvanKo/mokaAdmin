<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moka extends Model
{
	protected $table = 'Mokas';	
	protected $guarded = [];

	public function Role()
	{
		return $this->belongsTo(Role::class,'moka');
	}
	public function photos()
	{
		return $this->hasMany(Photo::class,'mokaid','mokaid');
	}

	public function getPhotos()
	{
	}
		
}
