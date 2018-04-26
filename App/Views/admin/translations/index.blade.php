@extends('admin.partials.layout')
@section('title', $lang['Translations'])
@section('content-title', $lang['Translations'])

@section('content')
@component('admin.partials.secondary-navigation')
  @slot('left')
    <button data-bind="click: $root.openAddTranslationPopup" class="button-primary">{{$lang['Add Translation']}}</button>
  @endslot
  @slot('right')
      <a data-bind="click: $root.saveTranslations" href="#" class="button-primary">{{$lang['Save']}}</a>
  @endslot
@endcomponent
<div style="display: none;" data-bind="visible: addTranslationPopupOpen, click: closePopup" class="popup__overlay"></div>
@component('admin.popups.add-translation-popup')@endcomponent
<div id="content">
@component('admin.components.alert')@endcomponent
<div class="container">
  <div class="row">
        <div class="col-12 col-md-4">
            <div class="admin-box">
              <div class="user-role-menu" data-bind="foreach: languages">
                <div class="user-role-menu__item" data-bind="click: $root.setCurrentLanguage, css: {active: id === $root.currentLanguage().id}">
                    <span data-bind="text: name"></span>
                </div>
            </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
          <div class="admin-box">
            <div class="admin-box__header" data-bind="with: currentLanguage">
              <h3 class="admin-box__title" data-bind="text: name"></h3>
            </div>
            <div data-bind="foreach: filteredTranslations">
              <div class="form-row">
                <div class="col-3">
                  <label data-bind="text: key" class="form-label"></label>
                </div>
                <div class="col-9">
                  <input data-bind="value: value" type="text" class="form-input">
                </div>
              </div>
            </div>
            <div data-bind="visible: filteredTranslations().length === 0" class="empty-state">
                <span class="empty-state__icon"><i class="fa fa-globe"></i></span>
                <div class="empty-state__text">{{$lang['No Translations']}}</div>
            </div>
            </div>
        </div>
    </div>
  </div>
</div>
@stop