<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Memo;

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
            \URL::forceScheme('https');
            view()->composer('*', function ($view) {
                // get the current user
                 // インスタンス化
                $memoModel = new Memo();
                $memos = $memoModel->myMemo( \Auth::id() );
                
                $view->with('memos', $memos);
            });
    }
}
