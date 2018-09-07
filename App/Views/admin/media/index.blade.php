@extends('admin.partials.layout')
@section('title', $lang['Media Manager'])
@section('content-title', $lang['Media Manager'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('right')
        <a data-bind="click: $root.openAddFolderPopup" class="button-primary-border mr-1">{{$lang['New Folder']}}</a>
        <a data-bind="click: $root.openUploadPopup" class="button-primary">{{$lang['Upload']}}</a>
    @endslot
@endcomponent
<div style="display: none;" data-bind="visible: popupOpen, click: closePopup" class="popup__overlay"></div>
@component('admin.popups.media-add-folder-popup')@endcomponent
@component('admin.popups.media-upload-popup')@endcomponent
<div id="content">
@component('admin.components.alert')@endcomponent
<div class="container">
        <div class="row">
            <div class="col-12">
                <div class="admin-box">
                   <div style="justify-content: space-between;" class="row mb-2">
                    <span class="form-checkbox">
                        <label for="enable-drop">
                            <input class="form-checkbox__input" id="enable-drop" type="checkbox" data-bind="checked: enableDrop">
                            <span class="form-checkbox__label">{{$lang['Enable Drop']}}</span>
                        </label>
                    </span>
                    <div class="media-admin__mode">
                        <span data-bind="css: {active: currentMode() === 'default'}, click: changeMode.bind(this, 'default')" class="media-admin__mode-item"><i class="fa fa-th-list"></i></span>
                        <span data-bind="css: {active: currentMode() === 'grid'}, click: changeMode.bind(this, 'grid')" class="media-admin__mode-item"><i class="fa fa-th"></i></span>
                    </div>
                  </div>
                    <div class="breadcrumbs">
                        <ul data-bind="foreach: pathArr">
                            <li data-bind="text: text, click: $root.changeDir"></li>
                        </ul>
                    </div>
                    <div data-bind="if: currentMode() === 'grid'" class="media-grid">
                        <div class="media-grid__wrapper" data-bind="visible: mediaElements().length > 0, foreach: {data: mediaElements}">
                            <div style="overflow: hidden;" data-bind="if: $index() === 0, visible: $index() === 0 && $root.currentDir() !== '/'" class="col-lg-3 col-md-4 col-12">
                                <div data-bind="click: $root.goDirBack" class="media-grid__item">
                                    <div style="margin-top: auto;">
                                        <i style="font-size: 5rem;" class="fa fa-arrow-left"></i>
                                    </div>
                                    <span class="media-grid__item-text">{{$lang['Go back']}}</span>
                            </div>
                            </div>
                            <div style="overflow: hidden;" class="col-lg-3 col-md-4 col-12">
                            <div data-bind="click: type() === 'dir' ? openFolder : openFile" class="media-grid__item">
                                <span class="media-grid__item-delete" data-bind="click: deleteMediaElement" class="cursor-p"><i class="fa fa-trash"></i></span>
                                <div style="margin-top: auto;">
                                    <div data-bind="if: type() === 'file'">
                                        <img data-bind="attr: {src: $root.baseURL + '/content/media' + path() + name()}" class="media-grid__item-img">
                                    </div>
                                    <div data-bind="if: type() ==='dir'">
                                        <i style="font-size: 5rem;" class="fa fa-folder"></i>
                                    </div>
                                </div>
                                <span class="media-grid__item-text" data-bind="text: name"></span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div data-bind="if: currentMode() === 'default'">
                        <table class="table normal">
                        <thead>
                            <tr>
                                <th>{{$lang['Name']}}</th>
                                <th>{{$lang['Size']}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tr data-bind="visible: $root.currentDir() !== '/', droppable: {data: moveDirBack, options:{greedy:true, accept: '.media-element'}}">
                            <td class="cursor-p" data-bind="click: goDirBack"><i class="fa fa-arrow-left pr-1"></span></i> <span>{{$lang['Go back']}}</span></td>
                            <td></td>
                            <td></td>                
                        </tr>
                        <tbody data-bind="visible: mediaElements().length > 0, sortable: {data: mediaElements, connectWith: 'tbody', connectClass: 'media-element', options: {revert: 'invalid', cancel: 'td:not(.editable), a:not(.arrow)'}}">
                            <tr class="media-element" data-bind="visible: $root.currentDir() == path(), css: {file: type() === 'file'}, droppable: type() === 'dir' ? {data: changeFolder, accept: '.media-element', isEnabled: $root.enableDrop} : {options: {disabled: true}}">
                                <td class="cancel cursor-p" style="position: relative;" data-bind="event: type() === 'file' ? {mouseover: hoverFile, mouseleave: removeHoverFile} : {}, click: type() === 'dir' ? openFolder : openFile">
                                   <span data-bind="if: type() === 'dir'"><i class="fa fa-folder pr-1"></i></span>
                                   <span data-bind="if: type() === 'file'"><i class="fa fa-image pr-1"></i></span>
                                   <span data-bind="text: name"></span>
                                   <span data-bind="if: type() === 'file' && imagePreview"><img class="img-preview" data-bind="attr: {src: $root.baseURL + '/content/media' + path() + name()}"></span>
                                  </td>
                                <td data-bind="text: size">{{$lang['Size']}}</td>
                                <td class="action editable auto-width">
                                    <a data-bind="click: deleteMediaElement" class="cursor-p"><i class="fa fa-trash"></i></a>
                                    <a class="cursor-m arrow"><i class="fa fa-arrows"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                <div data-bind="visible: mediaElements().length === 0" class="empty-state">
                    <span class="empty-state__icon"><i class="fa fa-file"></i></span>
                    <div class="empty-state__text">{{$lang['No Files/Folders']}}</div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop