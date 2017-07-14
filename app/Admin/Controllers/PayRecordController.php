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
use DB;

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
			$grid->model()->where('type','<=','3');

            $grid->id('ID');
			 $grid->column('moka','作者')->display(function($value){
                $name = DB::table("Roles")->where('moka','=',$value)->select(['name','moka','role'])->first();
                if(!$name){
                    return '未知';
                }
                switch ($name->role){
                    case 1:
                        return "<a href='model?moka=$name->moka'>$name->name</a>";
                        break;
                    case 2:
                        return "<a href='photographer?moka=$name->moka'>$name->name</a>";
                        break;
                    case 3:
                        return "<a href='manager?moka=$name->moka'>$name->name</a>";
                        break;
                    case 4:
                        return "<a href='company?moka=$name->moka'>$name->name</a>";
                        break;
                    default:
                        return "<a href='undefineUser?moka=$name->moka'>$name->name</a>";
                        break;
                }
            });
			//$grid->name('名字');
			$grid->openid('微信标识');
			$grid->tel('手机');
			$grid->type('类型')->display(function($type){
				switch($type){
				case 1:
					return '普通会员';
				case 2:
					return '高级会员';
				case 3:
					return '至尊会员';
		        case 4:
					return '打赏';
				default:
					return '未知';
				}
			});
			$grid->time('购买时长/月');
			$grid->amount('金额');
			$grid->status('状态')->display(function($status){
				return $status?'已支付':'未支付';
			})->sortable();
			$grid->filter(function ($filter) {
			 // 设置created_at字段的范围查询
			    $filter->between('created_at', 'Created Time')->datetime();
				$filter->disableIdFilter();

			    });
			// $grid->actions(function ($actions) {
			// 	$actions->disableEdit();
			// });
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
        $form->display('moka','id');
        $form->display('name','名字');
        $form->text('tel','手机');
        $form->select('type','类型')->options(['1'=>'普通会员','2'=>'高级会员','3'=>'至尊会员']);
     
        $form->currency('amount','金额')->symbol('￥');
		$form->number('time','月份数');
	 		$form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
