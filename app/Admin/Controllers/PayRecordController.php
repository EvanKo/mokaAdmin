<?php

namespace App\Admin\Controllers;

use App\PayRecord;
use Illuminate\Http\Request;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class PayRecordController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Request $request)
	{
        return Admin::content(function (Content $content) {

            $content->header('会员购买记录');
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

            $content->header('header');
            $content->description('description');

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
        return Admin::grid(PayRecord::class, function (Grid $grid) {

            $grid->id('ID');
			$grid->moka('mokaID')->sortable();
			$grid->name('名字');
			$grid->openid('微信标识');
			$grid->tel('手机');
			$grid->type('类型')->display(function($type){
				return $type?'高级会员':'普通会员';
			});
			$grid->amount('金额');
			$grid->status('状态')->display(function($status){
				return $status?'已支付':'未支付';
			});
			$grid->filter(function ($filter) {
			 // 设置created_at字段的范围查询
			    $filter->between('created_at', 'Created Time')->datetime();
				$filter->disableIdFilter();

			    });
			$grid->actions(function ($actions) {
				$actions->disableEdit();
			});
			$grid->disableCreation();
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
        return Admin::form(PayRecord::class, function (Form $form) {

					$form->undisplay('id', 'ID');
		$form->tab('Basic info', function ($form) {
	    	$form->text('moka');
		    $form->text('openid');
		    $form->text('name');
		    $form->text('tel');
		    $form->text('type');
		    $form->text('amount');
		    $form->text('status');
		});     
	 		$form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}