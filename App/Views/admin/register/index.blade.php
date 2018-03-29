@extends('admin.partials.background-layout')
@section('title', 'Register')

@section('content')
    <div class="box-wrapper">
        <div class="box">
            <div class="box__title"><h2>{{$lang['Register']}} {{$lang['for']}} <strong>PPCMS</strong></h2></div>
            @if(isset($formErrors))
                @foreach ($formErrors as $formError)
                    <p>{{$formError}}</p>
                @endforeach
            @endif

            @if(isset($error))
                <p>{{$error}}</p>
            @endif
            <form id="validate-form" method="POST" action="/admin/register">
                <input name="csrf_token" type="hidden" value="{{$csrf}}">
                <div class="form-row">
                    <div id="user" class="form-input-icon">
                        <input data-required="true" data-valtype="text" class="form-input validate" placeholder="Name" type="text" name="user[name]">
                    </div>
                </div>
                <div class="form-row">
                    <div id="email" class="form-input-icon">
                        <input data-required="true" data-valtype="email" class="form-input validate" placeholder="E-Mail" type="text" name="user[email]">
                    </div>
                </div>
                <div class="form-row">
                    <div id="password" class="form-input-icon">
                        <input id="passwd" data-required="true" data-valtype="password" class="form-input validate" placeholder="Password" type="password" name="user[password]">
                    </div>
                </div>
                <div class="form-row">
                    <div id="password" class="form-input-icon">
                        <input data-required="true" data-valtype="repeatpassword" class="form-input validate" placeholder="Repeat Password" type="password" name="user[repeat_password]">
                    </div>
                </div>
                <button class="button-primary block">{{$lang['Register']}}</button>
            </form>

            <span class="box__info">{{$lang['Already have an Account']}} - <a href="/admin/login">{{$lang['Login']}} {{$lang['here']}}</a></span>
        </div>
    </div>
@stop