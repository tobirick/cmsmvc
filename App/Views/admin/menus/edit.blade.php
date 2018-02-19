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
                <form id="add-menu-item" action="/admin/menus/{{$menu['id']}}/menuitems" method="POST">
                    <input name="csrf_token" type="hidden" value="{{$csrf}}">
                    <input name="menu_id" type="hidden" value="{{$menu['id']}}">
                    <div class="form-row">
                        <div class="col-6">
                            <input class="form-input" type="text" placeholder="Name" name="menuitem[name]">
                        </div>
                        <div class="col-4">
                            <select class="form-input" name="menuitem[page]">
                                @foreach($pages as $page)
                                    <option value="{{$page['id']}}">{{$page['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-1">
                            <button class="button-primary-icon"><i class="fa fa-check"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div>
    <table class="table">
        <tbody data-bind="foreach: menuListItems">
            <tr>
                <td>#</td>
                <td>
                                     <div class="row">
                                     <div class="col-10">
                    <form method="POST">
                     <input type="hidden" name='_METHOD' value="PUT">
                     <input name="csrf_token" type="hidden" value="{{$csrf}}">
                     <div class="form-row">
                     <div class="col-5">
                              <input class="form-input" data-bind="value: name" type="text" placeholder="Name" name="menuitem[name]">
                              </div>
                              <div class="col-5">
                              <select class="form-input" data-bind="options: $root.pagesList, optionsText: 'name', value: selectedPage, optionsValue: 'id'" name="menuitem[page]"></select>
                              </div>
                              <div class="col-2">
                        <button class="button-primary-icon"><i class="fa fa-check"></i></button>
                        </div>
                        </div>
                        </form>
                        </div>
                        <div class="col-2">
                        <form method="POST">
                            <input type="hidden" name='_METHOD' value="DELETE">
                            <input name="csrf_token" type="hidden" value="{{$csrf}}">
                            <button class="button-error-icon"><i class="fa fa-trash"></i></button>
                        </form>
                        </div>
                </div>
            </td>
            </tr>
        </tbody>
    </table>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="admin-box">
                <h3 class="admin-box__title">Menu Item's</h3>
                @if(isset($menuitems))
                    <div id="menu-list">
                        <table class="table">
                        <tbody>
                            @foreach ($menuitems as $menuitem)
                                <tr>
                                <td>#</td>
                                <td>
                                    <form id="update-menu-item" action="/admin/menus/{{$menu['id']}}/menuitems/{{$menuitem['id']}}" method="POST">
                                        <input type="hidden" name='_METHOD' value="PUT">
                                        <input name="csrf_token" type="hidden" value="{{$csrf}}">
                                        <div class="row">
                                            <div class="col-5">
                                                <input class="form-input" value="{{$menuitem['name']}}" type="text" placeholder="Name" name="menuitem[name]">
                                            </div>
                                            <div class="col-5">
                                                <select class="form-input" name="menuitem[page]">
                                                    @foreach($pages as $page)
                                                        <option value="{{$page['id']}}" {{ $menuitem['page_id'] === $page['id'] ? 'selected' : ''}}>{{$page['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button class="button-primary-icon"><i class="fa fa-check"></i></button>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <form id="delete-menu-item" action="/admin/menus/{{$menu['id']}}/menuitems/{{$menuitem['id']}}" method="POST">
                                        <input type="hidden" name='_METHOD' value="DELETE">
                                        <input name="csrf_token" type="hidden" value="{{$csrf}}">
                                        <button class="button-error-icon"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop