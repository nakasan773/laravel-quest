@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <p>アカウントを削除すると、ログインができなくなり、登録した文も全て削除されます。</p>
            <p>本当に削除してよろしいですか？</p>
        </div>
    </div>
    <div class="col-md-2 col-md-offset-5">
        {!! Form::open(['route' => ['users.destroy', Auth::user()->id], 'method' => 'delete']) !!}
            {!! Form::submit('削除する', ['class' => 'btn btn-danger btn-block']) !!}
        {!! Form::close() !!}
    </div>
    <div class="col-md-2 col-md-offset-5 spacer">
        {!! link_to_route('users.show', '削除しない', ['id' => Auth::user()->id], ['class' => 'btn btn-primary btn-block']) !!}
    </div>
@endsection