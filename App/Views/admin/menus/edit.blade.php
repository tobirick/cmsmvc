@extends('admin.partials.layout')
@section('title', $lang['Edit'] . ' ' . $menu['name'])
@section('content-title')
{{$lang['Edit']}} '{{$menu['name']}}'
@stop

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/menus" class="button-primary-border">{{$lang['Go back']}}</a>
    @endslot
    @slot('right')
        <a id="submit-form-btn" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="admin-box">
                <h3 class="admin-box__title">{{$lang['Main Settings']}}</h3>
                <form id="submit-form" action="/admin/menus/{{$menu['id']}}" method="POST">
                    <input type="hidden" name='_METHOD' value="PUT">
                    <input name="csrf_token" type="hidden" value="{{$csrf}}">
                    <div class="form-row">
                       <div class="col-3">
                          <label for="name" class="form-label">Menu Name</label>
                       </div>
                       <div class="col-9">
                          <input id="name" class="form-input" value="{{$menu['name']}}" type="text" placeholder="Name" name="menu[name]">
                       </div>
                    </div>
                    @foreach ($allmenus as $allmenu)
                    <span class="form-checkbox">
                     <label for="{{$allmenu['name']}}">
                        <input id="{{$allmenu['name']}}" class="form-checkbox__input" {{$menu['id'] === $allmenu['value'] ? 'checked' : ''}} name="menu[{{$allmenu['name']}}]" type="checkbox" value="{{$menu['id']}}"> 
                        <span class="form-checkbox__label">{{$allmenu['name']}}</span>
                     </label>
                     </span>
                    @endforeach
                </form>
            </div>
        </div>
    <div class="col-12 col-md-12">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="admin-box">
                    <h3 class="admin-box__title">{{$lang['New Menu Item']}}</h3>
                        <div class="form-row">
                            <div class="col-6">
                                <input data-bind="value: newMenuItem.name, valueUpdate: 'afterkeydown'" class="form-input" type="text" placeholder="Name">
                            </div>
                            <div class="col-4">
                                <select class="form-input" data-bind="options: $root.pagesList, optionsText: 'name', optionsValue: 'id', value: newMenuItem.page_id"></select>
                            </div>
                            <div class="col-1">
                                <button data-bind="click: addMenuListItem" class="button-primary-icon"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="admin-box">
                    <h3 class="admin-box__title">Add new Menu Item Link</h3>
                        <div class="form-row">
                            <div class="col-6">
                                <input data-bind="value: newMenuItem.name, valueUpdate: 'afterkeydown'" class="form-input" type="text" placeholder="Name">
                            </div>
                            <div class="col-4">
                                <input type="text" data-bind="value: newMenuItem.link_to, " class="form-input" placeholder="Link">
                            </div>
                            <div class="col-1">
                                <button data-bind="click: addMenuListItemLink" class="button-primary-icon"><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        </div>
    </div>
 
    <div class="row">
        <div class="col-12">
            <div class="admin-box mb-1">
                <div class="languages-tab">
                    <ul data-bind="foreach: languages">
                        <li data-bind="click: $root.setCurrentLanguage, text: name, css: {active: id === $root.currentLanguage().id}">Deutsch</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="admin-box">
                <h3 class="admin-box__title">{{$lang['Menu']}} Item's</h3>
                    <div id="menu-list">
                        <div data-bind="visible: filteredMenuItems().length > 0" class="table-responsive">
                            <div class="menu">
                                <div data-bind="sortable: {data: filteredMenuItems}" class="menu__items-wrapper">
                                    <div class="menu__item-wrapper">
                                        <div class="menu__item">
                                            <div>
                                                <i data-bind="visible: type() === 'page'" class="fa fa-file"></i>
                                                <i data-bind="visible: type() === 'link'" class="fa fa-link"></i>
                                                <input class="form-input" data-bind="value: name, valueUpdate: 'afterkeydown'" type="text" placeholder="Name">
                                            </div>
                                            <div>
                                                <input placeholder="Link" type="text" class="form-input" data-bind="visible: type() === 'link', value: link_to, valueUpdate: 'afterkeydown'">
                                                <select class="form-input" data-bind="visible: type() === 'page', options: $root.pagesList, optionsText: 'name', value: page_id, optionsValue: 'id'"></select>
                                            </div>
                                            <div>
                                                <input placeholder="CSS Klasse" data-bind="value: css_class, valueUpdate: 'afterkeydown'" type="text" class="form-input">
                                            </div>
                                            <div class="action">
                                                <button data-bind="click: updateMenuListItem"><i class="fa fa-check"></i></button>
                                                <button data-bind="click: deleteMenuListItem"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                                <div style="min-height: 25px;" data-bind="sortable: {data: subListItems}" class="submenu">
                                                    <div class="submenu__item">
                                                        <div>
                                                                <i data-bind="visible: type() === 'page'" class="fa fa-file"></i>
                                                                <i data-bind="visible: type() === 'link'" class="fa fa-link"></i>
                                                            <input data-bind="value: name, valueUpdate: 'afterkeydown'" class="form-input" type="text" placeholder="Name"> 
                                                        </div>
                                                        <div>
                                                                <input placeholder="Link" type="text" class="form-input" data-bind="visible: type() === 'link', value: link_to, valueUpdate: 'afterkeydown'">
                                                                <select class="form-input" data-bind="visible: type() === 'page', options: $root.pagesList, optionsText: 'name', value: page_id, optionsValue: 'id'"></select>
                                                            </div>
                                                        <div>
                                                                <input placeholder="CSS Klasse" data-bind="value: css_class, valueUpdate: 'afterkeydown'" type="text" class="form-input">
                                                        </div>
                                                        <div class="action">
                                                                <button data-bind="click: updateMenuListItem"><i class="fa fa-check"></i></button>
                                                                <button data-bind="click: deleteMenuListItem"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-bind="visible: filteredMenuItems().length === 0" class="empty-state">
                            <span class="empty-state__icon"><i class="fa fa-user-secret"></i></span>
                            <div class="empty-state__text">{{$lang['No Menu Items']}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
    <input type="hidden" id="menuid" value="{{$menu['id']}}">
@stop