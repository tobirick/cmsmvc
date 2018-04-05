@extends('admin.partials.layout')
@section('title', $lang['Add new Menu'])
@section('content-title', $lang['Add new Menu'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/menus" class="button-primary-border">{{$lang['Go back']}}</a>
    @endslot
    @slot('right')
        <a id="submit-form-btn" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="admin-box">
                    <form id="submit-form" action="/admin/menus" method="POST">
                        <input name="csrf_token" type="hidden" value="{{$csrf}}">
                        <div class="form-row">
                            <div class="col-12">
                                <input data-required="true" class="form-input validate" type="text" placeholder="Name" name="menu[name]">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop