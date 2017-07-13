<?php

namespace App\Admin\Controllers;

use App\Moment;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use DB;

class MomentController extends Controller
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

            $content->header('动态');
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
        return Admin::grid(Moment::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->disableCreation();
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
            $grid->content('内容');
            $grid->img('图片')->image('',100,100);
            $grid->column('view','阅读量');
            $grid->filter(function($filter){
			    // 禁用id查询框
			    $filter->disableIdFilter();
			    // sql: ... WHERE `user.email` = $email;
			    $filter->is('moka', '摩卡ID');
            });

            $grid->actions(function ($actions) {
				$actions->disableEdit();
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
        return Admin::form(Moment::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
