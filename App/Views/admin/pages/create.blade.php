@extends('admin.partials.layout')
@section('title', 'Create Page')
@section('content-title', 'Add new Page')

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
    Create Page
    <form action="/admin/pages" method="POST">
        <input name="csrf_token" type="hidden" value="{{$csrf}}">
        <input type="text" placeholder="Slug" name="page[slug]">
        <input type="text" placeholder="Name" name="page[name]">
        <input type="text" placeholder="Title" name="page[title]">
        <textarea name="page[content]"></textarea>
        <button>Add Page</button>
    </form>
</div>
</div>
@stop