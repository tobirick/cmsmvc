@extends('admin.partials.layout')
@section('title', 'Admin Menus')
@section('content-title', 'Menus')

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/admin/menus/create" class="button-primary">New Menu</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <div>
        @if(isset($menus))
        @foreach($menus as $menu)
            <div>
                {{$menu['name']}}
                <a href="/admin/menus/{{$menu['id']}}/edit">Edit</a>
                <form action="/admin/menus/{{$menu['id']}}" method="POST">
                    <input type="hidden" name='_METHOD' value="DELETE">
                    <input name="csrf_token" type="hidden" value="{{$csrf}}">
                    <button>Delete</button>
                </form>
            </div>
        @endforeach
        @endif
    </div>
</div>
</div>
@stop