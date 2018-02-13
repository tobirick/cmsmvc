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
        
    </div>
</div>
</div>
@stop