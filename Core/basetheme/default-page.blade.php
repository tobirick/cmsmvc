@extends('public.themes.' . $activetheme . '.partials.layout')
@section('title', $title)
@section('metatitle', $seo_title)
@section('metadescription', $seo_description)

@section('content')
    {!! trim($langcontent) !!}
@stop