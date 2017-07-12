<?php

namespace App\Admin\Controllers;

use App\Album;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use DB;

class AlbumController extends Controller
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

            $content->header('个人相册');
           // $content->description('description');

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
        return Admin::grid(Album::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('moka','作者')->display(function($value){
                $name = DB::table("Roles")->where('moka','=',$value)->select(['name','moka'])->first();
                if(!$name){
                    return '无';
                }
                return "<a href='model?moka=$name->moka'>$name->name</a>";
            });
			$grid->img('封面')->image('',100,100);
			$grid->albumname('相册名字');
            $grid->created_at()->sortable();
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
        return Admin::form(Album::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->image('img','封面');
            $form->text('albumname','相册名字');
            $form->text('moka','moka');
            $form->text('sum');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
