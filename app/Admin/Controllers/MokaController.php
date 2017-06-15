<?php

namespace App\Admin\Controllers;

use App\Moka;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

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

            $content->header('摩卡');
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

            $content->header('headertest');
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
        return Admin::grid(Moka::class, function (Grid $grid) {
			//$grid->model()->where('id','=','2');
            $grid->id('作者id')->sortable();
			$grid->mokaid('摩卡相册id')->sortable();
			$grid->area('地区');
			$grid->column('view','访问量');
			$grid->photos('照片')->dispaly(function($photos){
				return "<img style='width:100px height:100px'>$photos</img>";
			});
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
				$form->text('area','area');
			});
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
