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
            <div class="col-12 col-md-5">
                <div class="admin-box">
                    <h3 class="admin-box__title"></h3>
                </div>
            </div>
            <div class="col-12 col-md-3">
               <div class="admin-box weather-clock">
                  <span class="time"></span>
                  <span class="date"></span>
                  <div>
                     <span class="city">Aichach</span>
                     <span class="weather">17° C</span>
                  </div>
               </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="admin-box">
                     <h3 class="admin-box__title"></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="admin-box">
                    <h3 class="admin-box__title">Aktivitäten</h3>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="admin-box">
                    <h3 class="admin-box__title">Aktionen</h3>
                </div>
            </div>
        </div>
    </div>
</div>

@stop