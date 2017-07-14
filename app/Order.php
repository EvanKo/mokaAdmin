<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $table = 'Orders';
      protected $fillable = array(
  'moka'
  ,'price'
  ,'type'
  ,'content'
  ,'img'
  ,'imgnum'
);
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
			      $query = DB::table('Records')->where(['target'=>2,'target_id'=>$id])->first(); 	 	
			      if($query){
				      DB::table('Records')->where(['target'=>2,'target_id'=>$id])->delete();
			      }else{
				      return ;
		      	}
        });
    }
}
