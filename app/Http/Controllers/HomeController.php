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
        return view('home');
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

        return view('create');
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
    
    public function edit($id){
        // 該当するIDのメモをデータベースから取得
        $user = \Auth::user();
        $memo = Memo::select('memos.*')->where('id', $id)->where('user_id', $user['id'])->where('status', 1)->first();
        //取得したメモをViewに渡す
        return view('edit',compact('memo'));
    }
    
    public function update(Request $request)
    {
        $data = $request->all();
        // MEMOモデルにDBへ保存する命令を出す
        // updateメソッドには配列を渡す update( ここに配列を渡す )
        Memo::where('id', $data['id'])->update( [ 'content' => $data['content'] ]);
        // リダイレクト処理
        return redirect()->route('home')->with('success', '更新が完了しました');
    }
    
     public function delete($id)
    {
        Memo::where('id', $id)->update(['status' => 2]);
        // リダイレクト処理
        return redirect()->route('home')->with('success', '削除が完了しました');
    }
}
