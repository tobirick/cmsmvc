@extends('admin.partials.layout')
@section('title', 'Edit Menu')
@section('content-title')
Edit '{{$menu['name']}}'
@stop

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/admin/menus" class="button-primary-border">Go back</a>
    @endslot
    @slot('right')
        <a id="submit-form-btn" href="#" class="button-primary">Save</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="admin-box">
                <h3 class="admin-box__title">Main Settings</h3>
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
                <h3 class="admin-box__title">Add new Menu Item</h3>
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
                <h3 class="admin-box__title">Menu Item's</h3>
                    <div id="menu-list">
                        <table class="table">
                            <tbody data-bind="foreach: menuListItems">
                                <tr>
                                    <td>#</td>
                                    <td>
                                     <div class="row">
                                        <div class="col-10">
                                            <div class="form-row">
                                                <div class="col-5">
                                                    <input class="form-input" data-bind="value: name, valueUpdate: 'afterkeydown'" type="text" placeholder="Name" name="menuitem[name]">
                                                </div>
                                                <div class="col-5">
                                                    <select class="form-input" data-bind="options: $root.pagesList, optionsText: 'name', value: page_id, optionsValue: 'id'" name="menuitem[page]"></select>
                                                </div>
                                                <div class="col-2">
                                                    <button data-bind="click: updateMenuListItem" class="button-primary-icon"><i class="fa fa-check"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button data-bind="click: deleteMenuListItem" class="button-error-icon"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
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
    <input type="hidden" id="csrftoken" value="{{$csrf}}">
@stop