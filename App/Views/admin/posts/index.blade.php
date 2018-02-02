@extends('admin.partials.layout')
@section('title', 'Admin Posts')
@section('content-title', 'Posts')

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/admin/posts/create" class="button-primary">New Post</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    Admin Posts
</div>
</div>
@stop