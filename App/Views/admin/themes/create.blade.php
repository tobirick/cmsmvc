@extends('admin.partials.layout')
@section('title', 'Create Theme')
@section('content-title', $lang['Add new Theme'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/themes" class="button-primary-border">{{$lang['Go back']}}</a>
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
                    <form id="submit-form" action="/admin/themes" method="POST">
                        <input name="csrf_token" type="hidden" value="{{$csrf}}">
                        <div class="form-row">
                            <input class="form-input" type="text" placeholder="Name" name="theme[name]">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop