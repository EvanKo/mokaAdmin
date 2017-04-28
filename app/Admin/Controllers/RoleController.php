<?php

namespace App\Admin\Controllers;

use App\Role;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RoleController extends Controller
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

            $content->header('用户');
            $content->description('摩卡');

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

            $content->header('用户');
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

            $content->header('header');
            $content->description('description');

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

            $grid->id('ID');
			$grid->moka('账户')->sortable();
			$grid->head('头像')->image(50,50);
			//$url = $grid->head();
			$grid->tel('手机号码');
			$grid->sex('性别');
			$grid->role('角色')->display(function($role){
				if($role=='1') return '模特';
				if($role=='2') return '摄影师';
				if($role=='3') return '经纪人';
				if($role=='4') return '公司';
			});
			$grid->provice('省份');
			$grid->city('城市');
			$grid->area('地区');
			$grid->v('会员等级')->display(function($c){
				return $c?'高级会员':'普通会员';
			});
            $grid->created_at();
            $grid->updated_at();
			//禁用创建
			$grid->disableCreation();
			$grid->actions(function ($actions) {

					$actions->row;
					$actions->disableEdit();
				    // append一个操作
				   $actions->append('<a href=""><i class="fa fa-eye"></i></a>');
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

            $form->display('id', 'ID');
			$form->text('moka');
			$form->image('head');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
