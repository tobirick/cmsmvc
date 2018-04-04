@extends('admin.partials.layout')
@section('title', $lang['Translations'])
@section('content-title', $lang['Translations'])

@section('content')
@component('admin.partials.secondary-navigation')
  @slot('right')
        <a data-bind="click: saveToDB" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div id="content">
@component('admin.components.alert')@endcomponent
<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="admin-box">
        
      </div>
    </div>
  </div>
</div>
</div>
@stop