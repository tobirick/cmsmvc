@extends('admin.partials.layout')
@section('title', $lang['Create Language'])
@section('content-title', $lang['Create Language'])

@section('content')
@component('admin.partials.secondary-navigation')
   @slot('left')
        <a href="/{{$curLang}}/admin/settings/languages" class="button-primary">{{$lang['Go back']}}</a>
    @endslot
    @slot('right')
        <a id="submit-form-btn" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
   <div class="row">
      <div class="col-12">
          <div class="admin-box">
               <form id="submit-form" action="/admin/settings/languages" method="POST">
                  <input name="csrf_token" type="hidden" value="{{$csrf}}">
                  <div class="form-row">
                      <input class="form-input" type="text" placeholder="Name" name="language[name]">
                  </div>
                  <div class="form-row">
                      <input class="form-input" type="text" placeholder="ISO" name="language[iso]">
                  </div>
              </form>
         </div>
      </div>
   </div>
</div>
@stop