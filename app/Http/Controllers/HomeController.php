<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Memo;
use App\Tag;
use App\MemoTag;

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
        // もしタグの指定があれば、特定のタグに含まれるデータのみを持ってくる
        // クエリパラメーター
        return view('home');
    }
    
    public function create()
    {
        // 表示ページに必要なデータを集める
        $user = \Auth::user();
        return view('create', compact('user'));
    }
    
    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        // POSTされたデータをDB（memosテーブル）に挿入
        // MEMOモデルにDBへ保存する命令を出す
        $memo_id = Memo::insertGetId(['content' => $data['content'], 'user_id' => $data['user_id'], 'status' => 1 ]);
        // タグテーブルにインサート
        // もし、同じタグ投稿された場合は、新しくtagsテーブルにinsertせず、既存のタグを紐づける
        if( $default_tag = Tag::where('name', $data['tag'])->where('user_id', $data['user_id'])->first() ){
            // 同じがタグがあった場合
            $tag_id = $default_tag['id'];
        }else{
            // 同じタグがない場合
            $tag_id = Tag::insertGetId(['name' => $data['tag'], 'user_id'=> $data['user_id'] ]);
        }
        
        MemoTag::insert(['memo_id' => $memo_id, 'tag_id' => $tag_id]);
        // リダイレクト処理
        return redirect()->route('home');
    }
    
    public function edit($id){
        // 該当するIDのメモをデータベースから取得
        $user = \Auth::user();
        $memo = Memo::select('memos.*', 'tags.id AS tag_id', 'tags.name AS tag_name')
          ->where('memos.id', $id)
          ->where('memos.user_id', $user['id'])
          ->where('status', 1)
          ->leftJoin('memo_tags', 'memo_id', '=', 'memos.id')
          ->leftJoin('tags', 'tags.id', '=','memo_tags.tag_id')
          ->first();
          //dd($memo);
        //取得したメモをViewに渡す
        $tags = Tag::where('user_id', $user['id'])->get();
        return view('edit',compact('memo', 'tags'));
    }
    
    public function update(Request $request)
    {
        $data = $request->all();
        // MEMOモデルにDBへ保存する命令を出す
        // updateメソッドには配列を渡す update( ここに配列を渡す )
        Memo::where('id', $data['id'])->update( [ 'content' => $data['content'] ]);
        // タグの更新
        // 既存のタグを調べる
        $current_tag_id = MemoTag::where('memo_id', $data['id'])->first();
        // もしタグが変わっていた場合はmemo_tagsテーブルを更新する
        if($current_tag_id['tag_id'] != $data['tag_id']){
            MemoTag::where('memo_id', $data['id'])->update(['tag_id' => $data['tag_id'] ]);
        }
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
