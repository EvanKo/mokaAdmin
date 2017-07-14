<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class Moment extends Model
{
	protected $table = 'Moments';
      protected $fillable = array('moka','content','img','imgnum','view','area');
	  public function Role()
	  {
		  return $this->belongsTo(Role::class,'moka');
	  }
	//删除时，同时删表Records的关联数据
	  public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            $id = $model->id;Log::info('model moment`s id:'.$id);
			$query = DB::table('Records')->where(['target'=>1,'target_id'=>$id])->first(); 	 	
			if($query)
			{
				DB::table('Records')->where(['target'=>1,'target_id'=>$id])->delete();
			}else{
				return ;
			}
        });
    }
}
