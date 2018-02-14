@extends('public.themes.trtheme.partials.layout')
@section('title', $title)

@section('content')
<div class="container">
Das ist ein base theme
    <h1>{{$title}}</h1>

    <p>{{$content}}</p>
</div>
@stop