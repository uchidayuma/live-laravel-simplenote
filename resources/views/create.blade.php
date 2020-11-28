@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">新規メモ作成</div>
                <div class="card-body">
                    <form method='POST' action="/store">
                        @csrf
                        <input type='hidden' name='user_id' value="{{ $user['id'] }}">
                        <textarea name='content'></textarea>
                        <button type='submit'>保存</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
