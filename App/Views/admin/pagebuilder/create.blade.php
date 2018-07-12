@extends('admin.partials.layout')
@section('title', $lang['Create Pagebuilder Item'])
@section('content-title', $lang['Create Pagebuilder Item'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/pagebuilder" class="button-primary-border">{{$lang['Go back']}}</a>
    @endslot
     @slot('right')
        <a data-bind="click: saveToDB" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div style="display:none;" data-bind="visible: popupOpen, click: closePopup" class="popup__overlay"></div>
@component('admin.popups.add-pagebuilder-item-add-field')@endcomponent
<div id="content">
@component('admin.components.alert')@endcomponent  
    <div class="container">
            <div data-bind="with: pagebuilderItem" class="row">
                    <div class="col-12 col-md-8">
                        <div class="admin-box">
                                <div class="form-row">
                                    <input placeholder="Name" data-bind="value: name" class="form-input" type="text">
                                </div>
                                <div class="form-row" style="position: relative;height:500px;">
                                    <div data-bind="ace: html, aceOptions: {mode: 'html', theme: 'xcode'}" id="editor"></div>
                                    <textarea placeholder="Content" data-bind="value: html" class="form-input"></textarea>
                                </div>
                                <div class="form-row">
                                     <input type="text" placeholder="Type" data-bind="value: type" class="form-input">
                                </div>
                                <div class="form-row dn">
                                    <input type="text" placeholder="Config" data-bind="value: config, attr:{disabled:true}" class="form-input">
                                </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="admin-box">
                            <div class="admin-box__header">
                                <h3 class="admin-box__title">{{$lang['Fields']}}</h3>
                                <button data-bind="click: $root.openPopup" class="button-primary">{{$lang['Add']}}</button>
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
<style>
    #editor { 
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 9999;
        border-radius: 4px;
        border: 1px solid #ddd;
    }
</style>
<script src="https://cloud9ide.github.io/emmet-core/emmet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.3/ace.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.3/theme-xcode.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.3/mode-html.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.3/ext-emmet.js"></script>
<script>
        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/xcode");
        editor.session.setMode("ace/mode/html");
        editor.setOption("enableEmmet", true);
    </script>
@stop