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

	//删除时，同时删表Records的关联数据
	  public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            $id = $model->id;Log::info('model moment`s id:'.$id);
			      $query = DB::table('Records')->where(['target'=>3,'target_id'=>$id])->first(); 	 	
			      if($query){
				      DB::table('Records')->where(['target'=>3,'target_id'=>$id])->delete();
			      }else{
				      return ;
		      	}
        });
    }
		
}
