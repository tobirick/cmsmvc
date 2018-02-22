@extends('admin.partials.layout')
@section('title', $lang['Dashboard'])
@section('content-title')
{{$lang['Dashboard']}}
@stop

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <h4>{{$lang['Welcome back']}} {{$user['name']}}!</h4>
    @endslot
@endcomponent
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="admin-box">
                    <h3 class="admin-box__title">Statistiken</h3>
                </div>
            </div>
            <div class="col-4">
                <div class="admin-box">
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="admin-box">
                    <h3 class="admin-box__title">Aktivitäten</h3>
                </div>
            </div>
            <div class="col-6">
                <div class="admin-box">
                    <h3 class="admin-box__title">Aktionen</h3>
                </div>
            </div>
        </div>
    </div>
</div>

@stop