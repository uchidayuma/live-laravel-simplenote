@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            
            <div class="card-header">ここにメモ一覧が並ぶ</div>
            <div class="card">
        @foreach($memos as $memo)
              <p>{{ $memo['content'] }}</p>
        @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <a href='/create'>メモの作成ページに移動</a>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
