@extends('admin.partials.layout')
@section('title', 'Create Theme')
@section('content-title', 'Add new Theme')

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/admin/themes" class="button-primary-border">Go back</a>
    @endslot
    @slot('right')
        <a href="#" class="button-primary">Save</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <form action="/admin/themes" method="POST">
        <input name="csrf_token" type="hidden" value="{{$csrf}}">
        <input type="text" placeholder="Name" name="theme[name]">
        <button>Add Theme</button>
    </form>
</div>
</div>
@stop