<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    public function top()
    {
        // ここに処理を書く
        dd('top');
        return view('home');
    }
    
     public function create()
    {
        // 表示ページに必要なデータを集める
        // なんらかのデータ加工を行う
        // 集めたデータをViewに渡す
        // ユーザーIDを取得
        $user = \Auth::user();
        // dd($user);
        // return view('create');
        return view('create',compact('user'));
    }
}
