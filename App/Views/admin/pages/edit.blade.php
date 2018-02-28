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
<div id="content">
    <div class="admin-draggable-cols-wrapper">
            <div class="admin-box">
                <div class="admin-box__toggle"><i class="fa fa-chevron-left"></i></div>
                <h3 class="admin-box__title">Grid</h3>
                <div data-bind="foreach: possibleColumns" class="admin-draggable-cols">
                    <div data-bind="draggable: {data: $data, connectClass: 'admin-grid-cols', options: {helper: 'clone', appendTo: 'body', greedy: true}}">
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
    </div>
        
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
                <div class="admin-grid-sections" data-bind="sortable: {data: sections, connectClass: 'admin-grid-sections'}">
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
                        <div data-bind="draggable: {data: $data}" class="admin-element-list-item">
                            <span data-bind="css: type" class="admin-element-list-item__type"></span>
                            <span data-bind="text: name" class="admin-element-list-item__name"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop