@extends('admin.partials.layout')
@section('title', 'Edit Page')
@section('content-title')
{{$lang['Edit']}} '{{$page['name']}}'
@stop

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/pages" class="button-primary-border">{{$lang['Go back']}}</a>
    @endslot
    @slot('right')
        <a id="submit-form-btn" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div class="admin-box admin-box-grid-fixed">
    <div class="admin-box__toggle"><i class="fa fa-chevron-left"></i></div>
    <h3 class="admin-box__title">Grid</h3>
    <div data-bind="foreach: possibleColumns" class="admin-draggable-cols">
        <div class="admin-dragged-col" data-bind="draggable: {data: $data, connectClass: 'admin-grid-col-wrapper', options: {helper: 'clone', appendTo: 'body', revert: 'invalid', greedy: true}}">
            <div data-bind="foreach: $parent.columns">
                <div data-bind="css: 'col-'+col()">
                     <div class="admin-grid-col">
                        col-<span data-bind="text: col"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>           
</div>
<div data-bind="visible: popupOpen, click: closeSettings" class="popup__overlay"></div>
@component('admin.popups.pagebuilder-section-popup')@endcomponent
@component('admin.popups.pagebuilder-row-popup')@endcomponent
@component('admin.popups.pagebuilder-element-popup')@endcomponent
<div id="content">    
<div class="container">
    <div class="row">

        <div class="col-9">
            <div class="admin-box">
                <form id="submit-form" action="/admin/pages/{{$page['id']}}" method="POST">
                    <input type="hidden" name='_METHOD' value="PUT">
                    <input name="csrf_token" type="hidden" value="{{$csrf}}">
                    <div class="form-row">
                        <input class="form-input" value="{{$page['slug']}}" type="text" placeholder="Slug" name="page[slug]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" value="{{$page['name']}}" type="text" placeholder="Name" name="page[name]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" value="{{$page['title']}}" type="text" placeholder="Title" name="page[title]">
                    </div>
                    <div class="form-row">
                        <textarea class="form-input" name="page[content]">{{$page['content']}}</textarea>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-3">
            <div class="admin-box">
            
            </div>
        </div>

        <div class="col-8">
            <div class="admin-box">
                <h3 class="admin-box__title">Pagebuilder</h3>
                <button class="button-primary fr" data-bind="click: savetoDB">{{$lang['Save']}}</button>
                <div class="admin-grid-sections" data-bind="sortable: {data: sections, connectClass: 'admin-grid-sections', options: {revert: 'invalid'}}">
                    @component('admin.components.pagebuilder-section')@endcomponent
                </div>
                <span data-bind="click: $root.addSection" class="admin-grid__add-section"><i class="fa fa-plus"></i> Add Section</span>
            </div>  
        </div>
        <div class="col-4">
            <div class="admin-box">
                <h3 class="admin-box__title">Elements</h3>
                <div data-bind="foreach: elements" class="row">
                    <div class="col-6">
                        <div data-bind="draggable: {data: $data, options: {revert: 'invalid'}}" class="admin-element-list-item">
                            <span data-bind="css: item_type" class="admin-element-list-item__type"></span>
                            <span data-bind="text: item_name" class="admin-element-list-item__name"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="pageid" value="{{$page['id']}}">
@stop