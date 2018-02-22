@extends('admin.partials.layout')
@section('title', 'Edit Menu')
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
                        <input class="form-input" value="{{$menu['name']}}" type="text" placeholder="Name" name="menu[name]">
                    </div>
                    @foreach ($allmenus as $allmenu)
                        <input {{$menu['id'] === $allmenu['value'] ? 'checked' : ''}} name="menu[{{$allmenu['name']}}]" type="checkbox" value="{{$menu['id']}}"> {{$allmenu['name']}}
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
                            <input data-bind="value: $root.newMenuItemName" class="form-input" type="text" placeholder="Name" name="menuitem[name]">
                        </div>
                        <div class="col-4">
                            <select class="form-input" data-bind="options: pagesList, optionsText: 'name', optionsValue: 'id', value: $root.newMenuItemPage" name="menuitem[page]"></select>
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
            <div class="admin-box">
                <h3 class="admin-box__title">{{$lang['Menu']}} Item's</h3>
                    <div id="menu-list">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Name</th>
                                    <th>Zugehörige Seite</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody data-bind="sortable: {data: menuListItems, options: { cancel: 'td:not(.editable), button:not(.sort), input, select' }}">
                                <tr>
                                    <td>#<span data-bind="text: menu_position"></span></td>
                                    <td>
                                        <input class="form-input" data-bind="value: name, valueUpdate: 'afterkeydown'" type="text" placeholder="Name" name="menuitem[name]">
                                    </td>
                                    <td>
                                        <select class="form-input" data-bind="options: $root.pagesList, optionsText: 'name', value: page_id, optionsValue: 'id'" name="menuitem[page]"></select>
                                    </td>
                                    <td style="text-align:right;" class="editable auto-width">
                                        <button data-bind="click: updateMenuListItem" class="button-primary-icon"><i class="fa fa-check"></i></button>
                                        <button data-bind="click: deleteMenuListItem" class="button-error-icon"><i class="fa fa-trash"></i></button>
                                        <button class="button-warning-icon sort"><i class="fa fa-arrows"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
    <input type="hidden" id="menuid" value="{{$menu['id']}}">
@stop