<?php

namespace App\Admin\Controllers;

use App\Order;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use DB;

class OrderController extends Controller
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

            $content->header('用户约拍订单');
            //$content->description('description');

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

            $content->header('订单编辑');
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
        return Admin::grid(Order::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('moka','作者')->display(function($value){
                $name = DB::table("Roles")->where('moka','=',$value)->select(['name','moka'])->first();
                if(!$name){
                    return '无';
                }
                return "<a href='model?moka=$name->moka'>$name->name</a>";
            });
            $grid->type('类型')->display(function($value){
                if($value=='1'){
                    return '约拍';
                }else if($value=='2'){
                    return '工作室约拍';
                }
            });
            $grid->reserved('预约时间')->display(function($value){
                if($value){
                    return $value;
                }else{
                    return '无人预约';
                }
            });
            $grid->title('标题');
            $grid->content('内容');
            $grid->label('标签');
            $grid->place('地点');
            $grid->lasting('持续时间')->display(function($value){
                if($value){
                    return $value.'小时';
                }else{
                    return '未填写';
                }
            });
            $grid->price('费用');
            // $grid->finished('状态')->display(function($value){
            //     switch $value{
            //         case 0:
            //     }
            // })
            $grid->filter(function($filter){
			// 禁用id查询框
			 $filter->disableIdFilter();
			// sql: ... WHERE `user.email` = $email;
			 $filter->is('moka', '摩卡ID');});
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
        return Admin::form(Order::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->date('reserved','预约时间')->fromat('YYYY-MM-DD');
            $form->number('lasting','持续时间')->help('单位:小时');
            $form->text('place','地点');
            $form->currency('price','价格')->symbol('￥');
            $form->text('content','备注/内容');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
