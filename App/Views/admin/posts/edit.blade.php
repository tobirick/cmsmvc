@extends('admin.partials.layout')
@section('title', 'Edit Post')
@section('content-title')
Edit ' '
@stop

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/admin/posts" class="button-primary-border">Go back</a>
    @endslot
    @slot('right')
        <a href="#" class="button-primary">Save</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    Edit Post
</div>
</div>
@stop