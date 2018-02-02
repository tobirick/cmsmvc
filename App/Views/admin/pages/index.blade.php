@extends('admin.partials.layout')
@section('title', 'Admin Pages')
@section('content-title', 'Pages')

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/admin/pages/create" class="button-primary">New Page</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <div>
        @foreach($pages as $page)
            <div>
                {{$page['name']}}
                <a href="/admin/pages/{{$page['id']}}/edit">Edit</a>
                <a target="_blank" href="/{{$page['slug']}}">Zur Seite</a>
                <form action="/admin/pages/{{$page['id']}}" method="POST">
                    <input type="hidden" name='_METHOD' value="DELETE">
                    <input name="csrf_token" type="hidden" value="{{$csrf}}">
                    <button>Delete</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
</div>
@stop