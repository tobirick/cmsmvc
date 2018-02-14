@extends('admin.partials.layout')
@section('title', 'Admin Themes')
@section('content-title', 'Themes')

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/admin/themes/create" class="button-primary">New Theme</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <div>
        @foreach ($themes as $theme)
            <div>
            {{$theme['name']}}
            <form action="/admin/themes/{{$theme['name']}}/{{$theme['id']}}" method="POST">
                <input type="hidden" name='_METHOD' value="DELETE">
                <input name="csrf_token" type="hidden" value="{{$csrf}}">
                <button>Delete</button>
            </form>
            <form action="/admin/themes/{{$theme['name']}}/{{$theme['id']}}" method="POST">
                <input type="hidden" name='_METHOD' value="PUT">
                <input name="csrf_token" type="hidden" value="{{$csrf}}">
                <button>Activate</button>
            </form>
            </div>
        @endforeach
    </div>
</div>
</div>
@stop