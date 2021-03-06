<?php

namespace App\Admin\Controllers;

use App\Moka;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use DB;

class MokaController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('摩卡相册');
            $content->description('');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('摩卡编辑');
            //$content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('headertest');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /*ti
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Moka::class, function (Grid $grid) {
			//$grid->model()->where('id','=','2');
            $grid->column('moka','作者')->display(function($value){
                $name = DB::table("Roles")->where('moka','=',$value)->select(['name','moka'])->first();
                if(!$name){
                    return '无';
                }
                return "<a href='model?moka=$name->moka'>$name->name</a>";
            });
			$grid->mokaid('摩卡相册id')->display(function($value){
                return "<a href='photo?mokaid=$value'>$value</a>";
            });
            
			$grid->area('地区')->display(function($value){
                    return self::getProvince($value);
                });
            $grid->imgnum('照片数量');
			$grid->column('view','访问量');
			// $grid->photos('照片')->display(function($photos){
			// 	//$data = self::getPhotosArray($photos);
                   
			// 	return json_encode($photos,true);
			// 		//return "<img style='width:100px height:100px'>$data</img>";
			// 	})->image('',100,100);
            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Moka::class, function (Form $form) {

			$form->display('id', 'ID');
			$form->text('moka', 'moka')->tab('Basic Info',function($form){
				$form->text('area','地区')->display(function($value){
                    return self::getProvince($value);
                });
			});
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    private static function getProvince($number)
    {
        $province = DB::table('Area')->where(['parent_id'=>'0','sort'=>$number])->first();
        return $province->name;
    }

    private static function getPhotosArray($datas)
    {
        foreach($datas as $data){
            $array[] = $data['img_s']; 
        }
        return json_encode($array,true);
    }
}
