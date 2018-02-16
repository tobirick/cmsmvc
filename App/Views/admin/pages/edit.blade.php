@extends('admin.partials.layout')
@section('title', 'Edit Page')
@section('content-title')
Edit '{{$name}}'
@stop

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/admin/pages" class="button-primary-border">Go back</a>
    @endslot
    @slot('right')
        <a id="submit-form-btn" href="#" class="button-primary">Save</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="admin-box">
                <form id="submit-form" action="/admin/pages/{{$id}}" method="POST">
                    <input type="hidden" name='_METHOD' value="PUT">
                    <input name="csrf_token" type="hidden" value="{{$csrf}}">
                    <div class="form-row">
                        <input class="form-input" value="{{$slug}}" type="text" placeholder="Slug" name="page[slug]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" value="{{$name}}" type="text" placeholder="Name" name="page[name]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" value="{{$title}}" type="text" placeholder="Title" name="page[title]">
                    </div>
                    <div class="form-row">
                        <textarea class="form-input" name="page[content]">{{$content}}</textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop