@extends('admin.partials.layout')
@section('title', 'Register')

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
    <form method="POST" action="/admin/register">
        <input name="csrf_token" type="hidden" value="{{$csrf}}">
        <input placeholder="Name" type="text" name="user[name]">
        <input placeholder="E-Mail" type="email" name="user[email]">
        <input placeholder="Password" type="password" name="user[password]">
        <button>Register</button>
    </form>
</div>
</div>
@stop