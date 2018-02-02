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
        <a href="#" class="button-primary">Save</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <form action="/admin/pages/{{$id}}" method="POST">
        <input type="hidden" name='_METHOD' value="PUT">
        <input name="csrf_token" type="hidden" value="{{$csrf}}">
        <input value="{{$slug}}" type="text" placeholder="Slug" name="page[slug]">
        <input value="{{$name}}" type="text" placeholder="Name" name="page[name]">
        <input value="{{$title}}" type="text" placeholder="Title" name="page[title]">
        <textarea name="page[content]">{{$content}}</textarea>
        <button>Update Page</button>
    </form>
</div>
</div>
@stop