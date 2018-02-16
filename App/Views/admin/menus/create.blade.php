@extends('admin.partials.layout')
@section('title', 'Create Menu')
@section('content-title', 'Add new Menu')

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/admin/menus" class="button-primary-border">Go back</a>
    @endslot
    @slot('right')
        <a id="submit-form-btn" href="#" class="button-primary">Save</a>
    @endslot
@endcomponent
<div id="content">
    <div class="container">
        Create Menu
        <form id="submit-form" action="/admin/menus" method="POST">
            <input name="csrf_token" type="hidden" value="{{$csrf}}">
            <input type="text" placeholder="Name" name="menu[name]">
        </form>
    </div>
</div>
@stop