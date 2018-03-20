@extends('admin.partials.layout')
@section('title', 'Admin Media Manager')
@section('content-title', $lang['Media Manager'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('right')
        <a href="#" data-bind="click: $root.openAddFolderPopup" class="button-primary-border">{{$lang['New Folder']}}</a>
        <a href="#" data-bind="click: $root.openUploadPopup" class="button-primary">{{$lang['Upload']}}</a>
    @endslot
@endcomponent
<div data-bind="visible: popupOpen, click: closePopup" class="popup__overlay"></div>
@component('admin.popups.media-add-folder-popup')@endcomponent
@component('admin.popups.media-upload-popup')@endcomponent
<div id="content">
<div class="container">
        <div class="row">
            <div class="col-12">
                <div class="admin-box">
                    <div class="breadcrumbs">
                        <ul data-bind="foreach: pathArr">
                            <li data-bind="text: text, click: $root.changeDir"></li>
                        </ul>
                    </div>
                    <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Größe</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tr data-bind="visible: $root.currentDir() !== '/', droppable: {data: moveDirBack, options:{greedy:true, accept: '.media-element'}}">
                        <td>#</td>
                        <td style="cursor: pointer;" data-bind="click: goDirBack"><i class="fa fa-undo"></span></i> <span>Go back</span></td>
                        <td></td>
                        <td></td>                
                    </tr>
                    <tbody data-bind="sortable: {data: mediaElements, connectWith: 'tbody', connectClass: 'media-element', options: {revert: 'invalid', cancel: 'td:not(.editable), a:not(.arrow)'}}">
                        <tr class="media-element" data-bind="visible: $root.currentDir() == path(), css: {file: type() === 'file'}, droppable: type() === 'dir' ? {data: changeFolder, accept: '.media-element'} : {options: {disabled: true}}">
                            <td>#</td>
                            <td class="cancel" style="cursor: pointer;" data-bind="click: type() === 'dir' ? openFolder : openFile"><span data-bind="if: type() === 'dir'"><i class="fa fa-folder"></span></i> <span data-bind="text: name"></span></td>
                            <td data-bind="text: size">Größe</td>
                            <td class="action editable auto-width">
                                <a href="#"><i class="fa fa-pencil"></i></a>
                                <a data-bind="click: deleteMediaElement" href="#"><i class="fa fa-trash"></i></a>
                                <a style="cursor: move;" class="arrow" href="#"><i class="fa fa-arrows"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop