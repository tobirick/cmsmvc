@extends('admin.partials.layout')
@section('title', 'Create Page')
@section('content-title', 'Add new Page')

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/pages" class="button-primary-border">{{$lang['Go back']}}</a>
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
                <form id="submit-form" action="/admin/pages" method="POST">
                    <input name="csrf_token" type="hidden" value="{{$csrf}}">
                    <div class="form-row">
                        <input class="form-input" type="text" placeholder="Slug" name="page[slug]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" type="text" placeholder="Name" name="page[name]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" type="text" placeholder="Title" name="page[title]">
                    </div>
                    <div class="form-row">
                        <textarea class="form-input" name="page[content]"></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@stop