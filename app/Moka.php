<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moka extends Model
{
	public function profile()
		    {
				        $this->hasOne(Profile::class);
						    }
}
