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
                    <h3 class="admin-box__title">Informations</h3>
                    <div class="mb-2">
                        <div><strong>You have {{sizeof($pages)}} <a href="/admin/pages">Pages</a>!</strong> <a href="/admin/pages/create"><em>{{sizeof($pages) === 0 ? 'Add your first page!' : ''}}</em></a></div>
                        <div><strong>You're <a href="/admin/settings">Maintenance Mode</a> is {{$settings['maintenance_mode'] ? 'activated' : 'deactivated'}}!</strong></div>
                    </div>
                    You are using the Theme <a href="/admin/themes">{{$activetheme}}</a>!
                </div>
            </div>
            <div class="col-12 col-md-3">
               <div class="admin-box weather-clock">
                  <span class="time"></span>
                  <span class="date"></span>
                  <div>
                     <span class="city">Nice city bro</span>
                     <span class="weather">Maybe sun</span>
                  </div>
               </div>
            </div>
            <!--<div class="col-12 col-md-4">
                <div class="admin-box">
                     <h3 class="admin-box__title"></h3>
                </div>
            </div>-->
        </div>
    <!--<div class="row">
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
    </div>-->
</div>

@stop