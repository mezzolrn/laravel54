<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{
    //个人设置页面
    public function setting()
    {
    	return view('user.setting');
    }

    //个人设置行为
    public function settingStore()
    {

    }

    //个人中心页面
    public function show(User $user)
    {
    	//个人信息の关注/粉丝/文章数
    	$user = User::withCount(['posts','stars','fans'])->find($user->id);

    	//个人文章列表
    	$posts = $user->posts()->orderBy('created_at', 'desc')->paginate(3);

    	//个人关注用户 
		$stars = $user->stars;
    	$susers = User::whereIn('id', $stars->pluck('star_id'))->withCount(['posts','stars','fans'])->get();

    	//粉丝用户列表
    	$fans = $user->fans;
    	$fusers = User::whereIn('id', $fans->pluck('fan_id'))->withCount(['posts','stars','fans'])->get();

    	return view('user.show',compact('user','posts','fusers','susers'));
    }

    //关注用户
    public function fan(User $user)
    {
    	$me = \Auth::user();
    	$me->doFan($user->id);

    	return [
    		'error' => 0,
    		'msg' => '',
    	];
    }

    //取消关注
    public function unfan(User $user)
    {
    	$me = \Auth::user();
    	$me->doUnfan($user->id);

    	return [
    		'error' => 0,
    		'msg' => '',
    	];
    }
}
