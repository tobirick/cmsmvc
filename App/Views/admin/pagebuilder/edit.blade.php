@extends('admin.partials.layout')
@section('title', 'Edit Pagebuilder Item')
@section('content-title')
{{$lang['Edit']}} '{{$item_name}}'
@stop

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/pagebuilder" class="button-primary-border">{{$lang['Go back']}}</a>
    @endslot
    @slot('right')
        <a data-bind="click: saveToDB" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div data-bind="visible: popupOpen, click: closePopup" class="popup__overlay"></div>
@component('admin.popups.add-pagebuilder-item-add-field')@endcomponent
<div id="content">
@component('admin.components.alert')@endcomponent  
    <div class="container">
        <div data-bind="with: pagebuilderItem" class="row">
            <div class="col-8">
                <div class="admin-box">
                        <div class="form-row">
                            <input placeholder="Name" data-bind="value: name" class="form-input" type="text">
                        </div>
                        <div class="form-row">
                            <textarea placeholder="Content" data-bind="value: html" class="form-input"></textarea>
                        </div>
                        <div class="form-row">
                             <input type="text" placeholder="Type" data-bind="value: type" class="form-input">
                        </div>
                        <div class="form-row">
                            <input type="text" placeholder="Config" data-bind="value: config, attr:{disabled:true}" class="form-input">
                        </div>
                </div>
            </div>
            <div class="col-4">
                <div class="admin-box">
                    <div class="admin-box__header">
                        <h3 class="admin-box__title">Fields</h3>
                        <button data-bind="click: $root.openPopup" class="button-primary">Add</button>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div data-bind="sortable: {data: configVM().elements, options: {revert: 'invalid'}}" class="pagebuilder-fields">
                                <div class="pagebuilder-field">
                                    <div class="pagebuilder-field__content">
                                        <span data-bind="text: name, css:{empty: name() === ''}"></span>
                                        <span data-bind="text: key, css:{empty: name() === ''}" class="not-so-light-text"></span>
                                    </div>
                                    <div class="pagebuilder-field__actions">
                                         <i data-bind="click: $root.copyToClipboard" class="fa fa-copy not-so-light-text"></i>
                                         <i data-bind="click: $root.openPopup" class="fa fa-pencil not-so-light-text"></i>
                                         <i data-bind="click: $root.removeField" class="fa fa-trash not-so-light-text"></i>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="pagebuilderitemid" value="{{$id}}">
@stop