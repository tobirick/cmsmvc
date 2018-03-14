@extends('admin.partials.layout')
@section('title', 'Admin Media Manager')
@section('content-title', $lang['Media Manager'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('right')
        <a href="#" data-bind="click: $root.addFolder" class="button-primary-border">{{$lang['New Folder']}}</a>
        <a href="#" data-bind="click: $root.openUploadPopup" class="button-primary">{{$lang['Upload']}}</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
        <div class="row">
            <div class="col-12">
                <div class="admin-box">
                    <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Größe</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody data-bind="sortable: {data: mediaElements}">
                    <!-- ko if: type() === 'file' -->
                        <tr data-bind="click: type() === 'dir' ? openFolder : openFile, css: {file: type() === 'file'}, droppable: type() === 'dir' ? {data: changeFolder, accept: '.file'} : {options: {disabled: true}}">
                            <td>#</td>
                            <td><span data-bind="if: type() === 'dir'"><i class="fa fa-folder"></span></i> <span data-bind="text: name"></span></td>
                            <td data-bind="text: size">Größe</td>
                            <td class="action">
                                <a href="#"><i class="fa fa-pencil"></i></a>
                                <a href="#"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <!-- /ko -->
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop