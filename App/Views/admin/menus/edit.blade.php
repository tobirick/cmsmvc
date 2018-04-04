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
        <div class="col-6">
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
    <div class="col-6">
            <div class="admin-box">
                <h3 class="admin-box__title">{{$lang['New Menu Item']}}</h3>
                <form data-bind="submit: addMenuListItem">
                    <input name="csrf_token" type="hidden" value="{{$csrf}}">
                    <input name="menu_id" type="hidden" value="{{$menu['id']}}">
                    <div class="form-row">
                        <div class="col-6">
                            <input data-bind="value: newMenuItem.name" class="form-input" type="text" placeholder="Name" name="menuitem[name]">
                        </div>
                        <div class="col-4">
                            <select class="form-input" data-bind="options: $root.pagesList, optionsText: 'name', optionsValue: 'id', value: newMenuItem.page_id" name="menuitem[page]"></select>
                        </div>
                        <div class="col-1">
                            <button class="button-primary-icon"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                </form>
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
                        <table data-bind="visible: filteredMenuItems().length > 0" class="table">
                            <thead>
                                <tr>
                                    <th>{{$lang['Name']}}</th>
                                    <th>{{$lang['Connected Page']}}</th>
                                    <th>{{$lang['Class']}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody data-bind="sortable: {data: filteredMenuItems, options: { cancel: 'td:not(.editable), button:not(.sort), input, select' }}">
                                <tr>
                                    <td>
                                        <input class="form-input" data-bind="value: name, valueUpdate: 'afterkeydown'" type="text" placeholder="Name" name="menuitem[name]">
                                    </td>
                                    <td>
                                        <select class="form-input" data-bind="options: $root.pagesList, optionsText: 'name', value: page_id, optionsValue: 'id'" name="menuitem[page]"></select>
                                    </td>
                                    <td>
                                        <input placeholder="z.B. button" data-bind="value: css_class, valueUpdate: 'afterkeydown'" type="text" class="form-input">
                                    </td>
                                    <td class="align-right editable auto-width">
                                        <button data-bind="click: updateMenuListItem" class="button-primary-icon"><i class="fa fa-check"></i></button>
                                        <button data-bind="click: deleteMenuListItem" class="button-error-icon"><i class="fa fa-trash"></i></button>
                                        <button class="button-warning-icon sort"><i class="fa fa-arrows"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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