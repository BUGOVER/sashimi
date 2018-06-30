@extends('layouts.app')

@section('content')
<form action="{{ url('login') }}" method="post" class="form-horizontal">
<h1>Вход</h1>

<!-- if there are login errors, show them here -->

<div class="form-group col-sm-12">
    {!! Form::label('username', 'Имя пользователя',['class'=> 'class="control-label']) !!}
    {!! Form::text('username', Form::old('username'), array('class'=>'col-sm-6 form-control','placeholder' => 'Имя пользователя')) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('password', 'Пароль', ['class'=>'control-label']) !!}
    {!!  Form::password('password', ['class'=>'col-sm-6 form-control', 'placeholder' => 'Пароль']) !!}
</div>

<div class="form-group col-sm-12">{!! Form::submit('Войти', ['class'=>'col-sm-4 btn btn-success'] ) !!} </div>
</form>

@endsection