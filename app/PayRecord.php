<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayRecord extends Model
{
    protected $table = 'PayRecords';
	protected $guard = [];
	public function Role()
	{
		return $this->hasMany(Role::class,'moka');
	}
}
