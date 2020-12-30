<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    public function myMemo($user_id){
        return $this::select('memos.*')->where('user_id', $user_id)->where('status', 1)->get();
    }
}
