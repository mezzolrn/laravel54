<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use \App\AdminRole;

class RoleController extends Controller
{
	//角色列表页面
	public function index()
	{
		$roles = \App\AdminRole::paginate(10);
		return view('admin.role.index',compact('roles'));
	}

	//角色创建页面
	public function create()
	{
		return view('admin.role.add');
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
    	$role = AdminRole::create(compact('name','description'));

    	//渲染
    	return redirect('/admin/roles');
	}	

	//角色授权页面
	public function permission(\App\AdminRole $role)
	{
		$permissions = \App\AdminPermission::all();
		$myPermissions = $role->permissions;
		return view('/admin/role/permission',compact('permissions','myPermissions','role'));
	}

	//储存角色授权
	public function storePermission(\App\AdminRole $role)
	{
		//验证
    	$this->validate(request(),[
    		'permissions' => 'required|array',
    	]);

    	//逻辑
    	$permissions = \App\AdminPermission::findMany(request('permissions'));
    	$myPermissions = $role->permissions;

    	//要增加的
    	$addPermissions = $permissions->diff($myPermissions);
    	foreach($addPermissions as $permission)
    	{
    		$role->grantPermission($permission);
    	}

    	//要删除的
    	$deletePermissions = $myPermissions->diff($permissions);
    	foreach($deletePermissions as $permission)
    	{
    		$role->deletePermission($permission);
    	}

    	//渲染
    	return redirect('/admin/roles');
	}

}