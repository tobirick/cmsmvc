@extends('admin.partials.layout')
@section('title', $lang['Media Manager'])
@section('content-title', $lang['Media Manager'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('right')
        <a href="#" data-bind="click: $root.openAddFolderPopup" class="button-primary-border">{{$lang['New Folder']}}</a>
        <a href="#" data-bind="click: $root.openUploadPopup" class="button-primary">{{$lang['Upload']}}</a>
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
                   <div class="row mb-2">
                    <span class="form-checkbox">
                        <label for="enable-drop">
                            <input class="form-checkbox__input" id="enable-drop" type="checkbox" data-bind="checked: enableDrop">
                            <span class="form-checkbox__label">{{$lang['Enable Drop']}}</span>
                        </label>
                    </span>
                  </div>
                    <div class="breadcrumbs">
                        <ul data-bind="foreach: pathArr">
                            <li data-bind="text: text, click: $root.changeDir"></li>
                        </ul>
                    </div>
                    <table class="table">
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
                                <a data-bind="click: deleteMediaElement" href="#"><i class="fa fa-trash"></i></a>
                                <a class="cursor-m arrow" href="#"><i class="fa fa-arrows"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
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