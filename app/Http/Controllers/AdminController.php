<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Grid;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Chart\Bar;
use Encore\Admin\Widgets\Chart\Doughnut;
use Encore\Admin\Widgets\Chart\Line;
use Encore\Admin\Widgets\Chart\Pie;
use Encore\Admin\Widgets\Chart\PolarArea;
use Encore\Admin\Widgets\Chart\Radar;
use Encore\Admin\Widgets\Collapse;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;
use App\Http\Moka;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
	public function getAll(Request $request)
	{
		return Admin::content(function (Content $content) {
			$content->header('用户');
			 $content->row(function ($row) {
				                 $row->column(3, new InfoBox('New Users', 'users', 'aqua', '/admin/users', '1024'));
								                 $row->column(3, new InfoBox('New Orders', 'shopping-cart', 'green', '/admin/orders', '150%'));
								                 $row->column(3, new InfoBox('Articles', 'book', 'yellow', '/admin/articles', '2786'));
												 $row->column(3, new InfoBox('Documents', 'file', 'red', '/admin/files', '698726'));
			 });
			$grid = Admin::grid(Moka::class, function(Grid $grid){
			});

		});
		//$data = DB::table('Mokas')->select()->get();
		//return $data;
	}
}
