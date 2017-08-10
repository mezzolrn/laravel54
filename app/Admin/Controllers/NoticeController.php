<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
	public function index()
	{
		$notices = \App\Notice::all();
		return view('admin.notice.index',compact('notices'));
	}

	public function create()
	{
		return view('admin.notice.create');
	}

	public function store()
	{
		//验证
		$this->validate(request(),[
			'title' => 'required|string',
			'content' => 'required',
		]);

		//逻辑
		$notice = \App\Notice::create(request(['title', 'content']));

		dispatch(new \App\Jobs\SendMessage($notice));

		//渲染
		return redirect('admin/notices');
	}

}