@extends('admin.partials.layout')
@section('title', $lang['Edit'] . ' ' . $language['name'])
@section('content-title', $lang['Edit'] . " '" . $language['name'] . "'")

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
            <form id="submit-form" action="/admin/settings/languages/{{$language['id']}}" method="POST">
                  <input name="csrf_token" type="hidden" value="{{$csrf}}">
                  <input type="hidden" name='_METHOD' value="PUT">
                  <div class="form-row">
                     <div class="col-2">
                        <label class="form-label" for="name">Name</label>
                     </div>
                     <div class="col-10">
                        <input id="name" class="form-input" type="text" value="{{$language['name']}}" placeholder="Name" name="language[name]">
                     </div>
                  </div>
                  <div class="form-row">
                     <div class="col-2">
                        <label class="form-label" for="iso">ISO</label>
                     </div>
                     <div class="col-10">
                        <input id="iso" class="form-input" type="text" value="{{$language['iso']}}" placeholder="ISO" name="language[iso]">
                     </div>
                  </div>
              </form>
         </div>
      </div>
   </div>
</div>
@stop