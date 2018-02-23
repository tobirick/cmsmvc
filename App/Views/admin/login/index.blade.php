@extends('admin.partials.background-layout')
@section('title', 'Login')

@section('content')
    <div class="box-wrapper">
        <div class="box">
            <div class="box__title"><h2>Login to <strong>PPCMS</strong></h2></div>
            @if(isset($formErrors))
            @foreach ($formErrors as $formError)
                <p class="form-error">{{$formError}}</p>
            @endforeach
            @endif

            @if(isset($error))
            <p class="form-error">{{$error}}</p>
            @endif
            <form id="validate-form" method="POST" action="/admin/login">
                <input name="csrf_token" type="hidden" value="{{$csrf}}">
                <div class="form-row">
                    <div id="email" class="form-input-icon">
                        <input placeholder="E-Mail" class="form-input validate" type="email" name="user[email]">
                    </div>
                </div>
                <div class="form-row">
                    <div id="password" class="form-input-icon">
                        <input placeholder="Password" class="form-input validate" type="password" name="user[password]">
                    </div>
                </div>
                <button class="button-primary block">Login</button>
            </form>

            <span class="box__info">No account? - <a href="/admin/register">Register here</a></span>
        </div>
    </div>
@stop