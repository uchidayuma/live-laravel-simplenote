<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Memo;

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
        // メモの一覧を取ってきてViewに渡す
        // Memoモデル通じて、自分の作ったメモを取ってくる
        // ユーザーIDを取得
        $user = \Auth::user();
        //dd($user);
        // メモの所有者が自分かつ、アクティブなものだけを取得
        $memos = Memo::select('memos.*')->where('user_id', $user['id'])->where('status', 1)->get();
        // dd($memos);
        return view('home', compact('memos'));
    }
    
    public function top()
    {
        // ここに処理を書く
        // dd('top');
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
    
    public function store(Request $request)
    {
        $data = $request->all();
        //dd($data);
        // POSTされたデータをDB（memosテーブル）に挿入
        // MEMOモデルにDBへ保存する命令を出す
        Memo::insert(['content' => $data['content'], 'user_id' => $data['user_id'], 'status' => 1 ]);
        // リダイレクト処理
        return redirect()->route('home');
    }
}
