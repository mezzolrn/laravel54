<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use \App\AdminPermission;

class PermissionController extends Controller
{
	//权限列表页面
	public function index()
	{
		$permissions = \App\AdminPermission::paginate(10);
		return view('admin.permission.index',compact('permissions'));
	}

	//权限创建页面
	public function create()
	{
		return view('admin.permission.add');
	}

	//创建操作
	public function store()
	{
		//验证
    	$this->validate(request(),[
    		'name' => 'required|min:2',
    		'description' => 'required',
    	]);

    	//逻辑
    	$name = request('name');
    	$description = request('description');
    	$permission = AdminPermission::create(compact('name','description'));

    	//渲染
    	return redirect('/admin/permissions');
	}	

}