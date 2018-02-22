@extends('admin.partials.background-layout')
@section('title', 'Register')

@section('content')
    <div class="box-wrapper">
        <div class="box">
            <div class="box__title"><h2>Register for <strong>PPCMS</strong></h2></div>
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
                <div class="form-row">
                    <div id="user" class="form-input-icon">
                        <input class="form-input" placeholder="Name" type="text" name="user[name]">
                    </div>
                </div>
                <div class="form-row">
                    <div id="email" class="form-input-icon">
                        <input class="form-input" placeholder="E-Mail" type="email" name="user[email]">
                    </div>
                </div>
                <div class="form-row">
                    <div id="password" class="form-input-icon">
                        <input class="form-input" placeholder="Password" type="password" name="user[password]">
                    </div>
                </div>
                <button class="button-primary block">Register</button>
            </form>

            <span class="box__info">Already have an account? - <a href="/admin/login">Login here</a></span>
        </div>
    </div>
@stop