<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Memo;
use App\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//            \URL::forceScheme('https');
            view()->composer('*', function ($view) {
                // get the current user
                 // インスタンス化
                $memoModel = new Memo();
                $memos = $memoModel->myMemo( \Auth::id() );
                
                // タグに取得
                 $tagModel = new Tag();
                 $tags = $tagModel->where('user_id', \Auth::id())->get();
                
                $view->with('memos', $memos)->with('tags', $tags);
            });
    }
}
