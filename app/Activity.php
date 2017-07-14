<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
      protected $table = 'Activities';
      protected $fillable = array('moka','img','type','title','area','content','view','pass',
      'finish','price','start','end','local');

      //删除时，同时删表Records的关联数据
	  public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            $id = $model->id;Log::info('model moment`s id:'.$id);
		$query = DB::table('Records')->where(['target'=>4,'target_id'=>$id])->first(); 	 	
	      if($query){
                  DB::table('Records')->where(['target'=>4,'target_id'=>$id])->delete();
		}else{
			return ;
		}
        });
    }
}
