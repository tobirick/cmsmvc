@extends('admin.partials.layout')
@section('title', $lang['Translations'])
@section('content-title', $lang['Translations'])

@section('content')
@component('admin.partials.secondary-navigation')
  @slot('left')
    <button class="button-primary">{{$lang['Add Translation']}}</button>
  @endslot
  @slot('right')
      <a href="#" class="button-primary">{{$lang['Save']}}</a>
  @endslot
@endcomponent
<div id="content">
@component('admin.components.alert')@endcomponent
<div class="container">
  <div class="row">
        <div class="col-3">
            <div class="admin-box">
                <div class="user-role-menu">
                    <div class="user-role-menu__item">
                      <span>English</span>
                    </div>
                    <div class="user-role-menu__item active">
                      <span>Deutsch</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-9">
          <div class="admin-box">
            <h3 class="admin-box__title">Deutsch</h3>
            <div class="form-row">
              <div class="col-3">
                <label for="" class="form-label">Footer Title 1</label>
              </div>
              <div class="col-9">
                <input type="text" class="form-input">
              </div>
            </div>
            <div class="form-row">
              <div class="col-3">
                <label for="" class="form-label">Footer Title 2</label>
              </div>
              <div class="col-9">
                <input type="text" class="form-input">
              </div>
            </div>
            </div>
        </div>
    </div>
  </div>
</div>
@stop