@extends('admin.partials.layout')
@section('title', $lang['Add new User'])
@section('content-title')
{{$lang['Add new User']}}
@stop

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/users" class="button-primary-border">{{$lang['Go back']}}</a>
    @endslot
    @slot('right')
        <a id="submit-form-btn" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <div class="row">
        
        <form class="w-100 df" id="submit-form" action="/admin/users" method="POST">
            <input name="csrf_token" type="hidden" value="{{$csrf}}">
        <div class="col-12">
            <div class="admin-box">
               <h3 class="admin-box__title">{{$lang['Add new User']}}</h3>
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
            </div>
        </div>
    </form>
    </div>
</div>
@stop