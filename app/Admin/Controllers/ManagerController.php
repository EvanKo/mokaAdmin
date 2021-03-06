<?php

namespace App\Admin\Controllers;

use App\Role;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ManagerController extends Controller
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

            $content->header('经纪人');
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

            $content->header('资料编辑');
            $content->description('');

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

            $content->header('新建经纪人');
            $content->description('');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Role::class, function (Grid $grid) {
			$grid->model()->where('role','=','3');

            $grid->id('ID');
			$grid->moka('账户')->sortable();
			$grid->head('头像')->display(function($head){
				return "<img src=http://os3h4gw7b.bkt.clouddn.com/$head width=50 height=50 >";
			});//image( 50);
			$grid->tel('手机号码');
			$grid->sex('性别')->display(function($value){
				if($value==1){
					return '男';
				}else if($value==0){
					return '女';
				}else{
					return '未知';
				}
			});
		/*	$grid->role('角色')->display(function($role){
				if($role=='1') return '模特';
				if($role=='2') return '摄影师';
				if($role=='3') return '经纪人';
				if($role=='4') return '公司';
		});*/
			$grid->area('地区')->display(function($value){
				return self::getProvince($value);
			});
			$grid->city('城市');
			$grid->v('会员等级')->display(function($v){
				switch($v){
				case 0:
					return '无';
				case 1:
					return '普通会员';
				case 2:
					return '高级会员';
				case 3:
					return '至尊会员';
				}
			});
			$grid->viptime('vip时间')->editable('date');
			$grid->money('余额');
            $grid->created_at();
            $grid->updated_at();
			//禁用创建
			//$grid->disableCreation();
			$grid->actions(function ($actions) {

					$actions->row;
					$actions->disableEdit();
				    // append一个操作
				 //  $actions->append('<a href=""><i class="fa fa-eye"></i></a>');
					//$actions->append("<video src='$url'>预览</video>");
				             });

			$grid->filter(function($filter){

			// 禁用id查询框
			 $filter->disableIdFilter();
			 $filter->is('tel','手机号码');
			// sql: ... WHERE `user.email` = $email;
			 $filter->is('moka', '摩卡ID');});
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Role::class, function (Form $form) {
		$form->tab('基本信息',function($form){
			$form->text('moka','id');
			$form->image('head','头像');
			$form->text('tel')->rules('max:11');
			$form->radio('sex','性别')->options(['1'=>'男','2'=>'女'])->default('1');
			//$form->select('role','角色身份')
			//->options(['1'=>'模特','2'=>'摄影师','3'=>'经纪人','4'=>'公司']);
			$form->hidden('role','1');
			$form->text('name','昵称');
			$form->text('province','省份');
			$form->text('city','城市');
			
			$form->password('password','密码')->rules('required');	
			$form->password('password','确认密码')->rules('required|confirmed');	
		})->tab('模特信息',function($form){
			$form->text('figure.height')->placeholder('单位:kg');
			$form->text('figure.weight')->placeholder('单位:cm');
			$form->text('figure.bust');
			$form->text('figure.waist');
			$form->text('figure.hips');
			$form->text('figure.shoe');
			$form->text('figure.exp');
		});
        });
    }
}
