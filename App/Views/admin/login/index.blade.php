@extends('admin.partials.background-layout')
@section('title', 'Login')

@section('content')
    <div class="box-wrapper">
        <div class="box">
            <div class="box__title"><h2>{{$lang['Login']}} to <strong>PPCMS</strong></h2></div>
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
                        <input data-required="true" data-valtype="email" placeholder="E-Mail" class="form-input validate" type="text" name="user[email]">
                    </div>
                </div>
                <div class="form-row">
                    <div id="password" class="form-input-icon">
                        <input data-required="true" data-valtype="password" placeholder="Password" class="form-input validate" type="password" name="user[password]">
                    </div>
                </div>
                <button class="button-primary block">{{$lang['Login']}}</button>
            </form>

            <span class="box__info">{{$lang['No account']}} - <a href="/admin/register">{{$lang['Register here']}}</a></span>
        </div>
    </div>
@stop