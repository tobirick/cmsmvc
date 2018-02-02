@extends('public.themes.trtheme.partials.layout')
@section('title', 'Home')

@section('content')
<div class="container">
    Hi wie gehts <strong>{{$user ? $user['name'] : 'unbekannter user'}}</strong><br>
    
    <div class="icon"></div>

    <a href="#">Test Link</a>

    <button class="button-primary">Normal</button>
    <button class="button-primary--small">Small</button>
    <button class="button-primary--large">Large</button>

    <a href="#" class="button-error">Normal</a>
    <a href="#" class="button-error--small">Small</a>
    <a href="#" class="button-error--large">Large</a>

    <h1>Griderify</h1>
    <div class="row">
        <div class="col">
            Col 1
        </div>
        <div class="col">
            Col 2
        </div>
        <div class="col">
            Col 3
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-3">
            Col 1
        </div>
        <div class="col-12 col-sm-6">
            Col 2
        </div>
        <div class="col-12 col-sm-3">
            Col 3
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 col-sm-3">
            Col 1
        </div>
        <div class="col-12 col-sm-3">
            Col 2
        </div>
        <div class="col-12 col-sm-3">
            Col 3
        </div>
        <div class="col-12 col-sm-3">
            Col 4
        </div>
        <div class="col-12 col-sm-3">
            Col 5
        </div>
        <div class="col-12 col-sm-3">
            Col 6
        </div>
        <div class="col-12 col-sm-3">
            Col 7
        </div>
        <div class="col-12 col-sm-3">
            Col 8
        </div>
        <div class="col-12 col-sm-3">
            Col 9
        </div>
        <div class="col-12 col-sm-3">
            Col 10
        </div>
       <div class="col-12 col-sm-3">
            Col 11
        </div>
        <div class="col-12 col-sm-3">
            Col 12
        </div>
    </div>
</div>
@stop