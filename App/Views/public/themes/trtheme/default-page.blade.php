@extends('public.themes.' . $activetheme . '.partials.layout')
@section('title', $title)
@section('metatitle', $seo_title)
@section('metadescription', $seo_description)

@section('content')
<div class="container">
    <h1>{{$title}}</h1>

    {!! trim($langcontent) !!}
</div>
@stop