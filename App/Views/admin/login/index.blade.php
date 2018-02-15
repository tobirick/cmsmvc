@extends('admin.partials.layout')
@section('title', 'Login')

@section('content')
<div id="content">
<div class="container">
    @if(isset($formErrors))
    @foreach ($formErrors as $formError)
        <p>{{$formError}}</p>
    @endforeach
    @endif

    @if(isset($error))
    <p>{{$error}}</p>
    @endif
    <form method="POST" action="/admin/login">
        <input name="csrf_token" type="hidden" value="{{$csrf}}">
        <input type="email" name="user[email]">
        <input type="password" name="user[password]">
        <button>Login</button>
    </form>
</div>
</div>
@stop