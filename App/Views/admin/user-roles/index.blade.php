@extends('admin.partials.layout')
@section('title', $lang['User Roles'])
@section('content-title', $lang['User Roles'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <button class="button-primary" data-bind="click: openAddUserRolePopup">{{$lang['Add User Role']}}</button>
    @endslot
    @slot('right')
        <a data-bind="click: saveToDB" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div style="display: none;" data-bind="visible: addUserRolePopupOpen, click: closePopup" class="popup__overlay"></div>
@component('admin.popups.user-roles-add-role-popup')@endcomponent
<div id="content">
@component('admin.components.alert')@endcomponent
<div class="container">
        <div class="row">
            <div class="col-3">
                <div class="admin-box">
                    <div class="user-role-menu" data-bind="foreach: userRoles">
                        <div class="user-role-menu__item" data-bind="click: $root.setSelectedUserRole, css: {active: id() === $root.selectedUserRole().id()}">
                            <span data-bind="text: user_role_name"></span>
                        </div>
                    </div>
                    <div data-bind="visible: userRoles().length === 0">
                        <div class="user-role-menu__item empty">
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="admin-box">
                    <div data-bind="with: selectedUserRole">
                        <div class="admin-box__header">
                            <div>
                                <h3 class="admin-box__title" data-bind="text: user_role_name"></h3>
                                <span data-bind="ifnot: is_admin()">
                                    <i data-bind="click: toggleEditMode" class="action-icon fa fa-pencil"></i>
                                    <i data-bind="click: deleteUserRole" class="action-icon fa fa-trash"></i>
                                </span>
                            </div>
                            <div>
                                <span data-bind="visible: !($root.userPermissions().length === activePermissions().length)">
                                    <button data-bind="click: checkAllPermissions" class="button-primary-border">{{$lang['Check all Permissions']}}</button>
                                </span>
                                <span data-bind="visible: $root.userPermissions().length === activePermissions().length">
                                    <button data-bind="click: uncheckAllPermissions" class="button-primary-border">{{$lang['Uncheck all Permissions']}}</button>
                                </span>
                            </div>
                        </div>
                        <div class="user-role-checkboxes" data-bind="foreach: $root.userPermissions">
                            <span class="form-checkbox">
                                <label data-bind="attr: {for: id()}, click: $parent.toggleCheckbox" for="enable-drop">
                                    <input class="form-checkbox__input" type="checkbox" data-bind="attr: {id: id()},checked: $parent.activePermissions().indexOf(id()) !== -1">
                                    <span class="form-checkbox__label" data-bind="text: permission_name"></span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <div data-bind="visible: userRoles().length === 0" class="empty-state">
                        <span class="empty-state__icon"><i class="fa fa-users"></i></span>
                        <div class="empty-state__text">{{$lang['No User Roles']}}</div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
@stop