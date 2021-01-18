@extends('layouts.app')

@section('css')
 <link href='/css/edit.css' rel="stylesheet">
@endsection

@section('footer')
<script>
  window.addEventListener('load',function(){
    var form = document.getElementById("delete-form");
    document.getElementById("delete-button").addEventListener("click", function () {
      form.submit();
    });
  })
</script>
@endsection

@section('content')
<div class="card h-100">
  <div class="card-header">
    <form method='POST' action="/delete/{{$memo['id']}}" id='delete-form'>
      @method('DELETE')
      @csrf
      <i id='delete-button' class="fas fa-trash"></i>
    </form>  
  </div>
  <div class="card-body">
    <form method='POST' action="/update" class='h-100'>
      @csrf
      <textarea class='edit-area' name='content'>{{ $memo['content'] }}</textarea>
      <input type='hidden' name='id' value="{{ $memo['id'] }}">
      <div class="form-group">
        <select class='form-control' name='tag_id'>
      @foreach($tags as $tag)
          <option value="{{ $tag['id'] }}" {{ $tag['id'] == $memo['tag_id'] ? "selected" : "" }}>{{$tag['name']}}</option>
      @endforeach
        </select>
      </div>
      <button class='btn btn-outline-primary btn-lg btn-block'>更新</button>
    </form>
  </div>
</div>
@endsection
