@extends('public.themes.' . $activetheme . '.partials.layout')
@section('title', 'Home')

@section('content')
<div class="container">
    Hi wie gehts <strong>{{$user ? $user['name'] : 'unbekannter user'}}</strong><br>
</div>
@stop