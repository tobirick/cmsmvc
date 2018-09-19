@extends('admin.partials.layout') 
@section('title', $lang['Edit'] . ' ' .$page['name']) 
@section('content-title') {{$lang['Edit']}}
'{{$page['name']}}' 
@stop 
@section('content') @component('admin.partials.secondary-navigation') @slot('left')
<a href="/{{$curLang}}/admin/pages" class="button-primary-border">{{$lang['Go back']}}</a> @endslot @slot('right')
<div class="center-v-flex">
    <a data-bind="attr: {href: $root.currentPageURL()}" target="_blank" class="button-primary-border mr-1">{{$lang['Preview']}}</a>
    <button class="button-primary fr" data-bind="click: savetoDB">{{$lang['Save']}}</button>
</div>
@endslot @endcomponent
<div class="admin-box admin-box-grid-fixed">
    <div class="admin-box__toggle"><i class="fa fa-chevron-left"></i></div>
    <h3 class="admin-box__title">Grid</h3>
    <div data-bind="foreach: possibleColumns" class="admin-draggable-cols">
        <div class="admin-dragged-col" data-bind="draggable: {data: $data, connectClass: 'admin-grid-col-wrapper', options: {helper: 'clone', appendTo: 'body', revert: 'invalid', greedy: true}}">
            <div data-bind="foreach: $parent.columns">
                <div data-bind="css: 'col-'+col()">
                    <div class="admin-grid-col">
                        col-<span data-bind="text: col"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display: none;" data-bind="visible: popupOpen, click: closeSettings" class="popup__overlay"></div>
@component('admin.popups.pagebuilder-section-popup')@endcomponent @component('admin.popups.pagebuilder-row-popup')@endcomponent
@component('admin.popups.pagebuilder-element-popup')@endcomponent
<div data-bind="with: popupOpen">
    <div style="display: none;" data-bind="visible: $root.mediaPopupVM().mediaPopupOpen, click: $root.mediaPopupVM().closeMediaPopup"
        class="popup__overlay higher-z"></div>
    @include('admin.popups.media-images-overview-popup')
</div>
<div id="content">
    @component('admin.components.alert')@endcomponent
    <div class="container">
        <div class="row">
            <div class="col-12" style="position: sticky;top: 0;z-index: 9;">
                <div class="admin-box mb-1">
                    <div class="languages-tab">
                        <ul data-bind="foreach: languages">
                            <li data-bind="click: $root.setCurrentLanguage, text: name, css: {active: id === $root.currentLanguage().id}">Deutsch</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div data-bind="with: page" class="col-12 col-md-7">
                <div class="admin-box">
                    <h3 class="admin-box__title">{{$lang['Default Settings']}}</h3>
                    <div class="form-row">
                        <div class="col-3">
                            <label for="pagename" class="form-label">{{$lang['Page Name']}}</label>
                        </div>
                        <div class="col-9">
                            <input id="pagename" autocomplete="off" class="form-input" data-bind="value: $root.defaultPageSettings().name" type="text"
                                placeholder="Name" name="page[name]">
                            <strong>Permalink: </strong> <a target="_blank" data-bind="text: $root.currentPageURL, attr: {href: $root.currentPageURL()}"></a>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                            <label for="slug" class="form-label">Slug</label>
                        </div>
                        <div class="col-9">
                            <input class="form-input" id="slug" data-bind="textInput: slug" type="text" placeholder="Slug" name="page[slug]">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                            <label for="pagetitle" class="form-label">{{$lang['Page Title']}}(max. 65)</label>
                        </div>
                        <div class="col-9">
                            <input id="pagetitle" class="form-input" data-bind="textInput: title, attr: {maxlength: 65}" type="text" placeholder="Title"
                                name="page[title]">
                            <span class="form-input__length" data-bind="text: title().length"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                            <label class="form-label">Page Active</label>
                        </div>
                        <div class="col-9">
                            <span class="form-checkbox">
                           <label for="active">
                              <input class="form-checkbox__input" id="active" type="checkbox" data-bind="checked: $root.defaultPageSettings().is_active">
                              <span class="form-checkbox__label">&nbsp;</span>
                            </label>
                            </span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                            <label class="form-label">White Logo</label>
                        </div>
                        <div class="col-9">
                            <span class="form-checkbox">
                           <label for="white-logo">
                              <input class="form-checkbox__input" id="white-logo" type="checkbox" data-bind="checked: $root.defaultPageSettings().white_logo_active">
                              <span class="form-checkbox__label">&nbsp;</span>
                            </label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div data-bind="with: page" class="col-12 col-md-5">
                <div class="admin-box">
                    <h3 class="admin-box__title">SEO</h3>
                    <div class="form-row">
                        <div class="col-3">
                            <label for="seotitle" class="form-label">SEO {{$lang['Title']}}(max. 65)</label>
                        </div>
                        <div class="col-9">
                            <input id="seotitle" class="form-input" data-bind="textInput: seo_title, attr: {maxlength: 65}" type="text" placeholder="SEO Title"
                                name="page[seo_title]">
                            <span class="form-input__length" data-bind="text: seo_title().length"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                            <label for="seodescription" class="form-label">SEO {{$lang['Description']}}(min. 100, max. 145)</label>
                        </div>
                        <div class="col-9">
                            <textarea data-bind="textInput: seo_description, attr: {maxlength: 145, minlength: 100}" id="seodescription" class="form-input"
                                type="text" placeholder="SEO Description" name="page[seo_description]"></textarea>
                            <span class="form-input__length" data-bind="text: seo_description().length, css: {'form-input__length--error': seo_description().length < 100, 'form-input__length--success': seo_description().length >= 100}"></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                            <label for="featureimg" class="form-label">Feature IMG</label>
                        </div>
                        <div class="col-9">
                            <div class="center-v-flex">
                                <input data-bind="value: $root.defaultPageSettings().feature_img" type="text" id="featureimg" class="form-input" placeholder="Image URL">
                                <button data-bind="click: $root.openFeatureImgMediaPopup" class="ml-1 button-primary">{{$lang['Choose Media']}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="admin-box">
                    <div class="admin-grid-sections" data-bind="sortable: {data: sections, connectClass: 'admin-grid-sections', options: {revert: 'invalid'}}">
                        @component('admin.components.pagebuilder-section')@endcomponent
                    </div>
                    <div class="cursor-p" data-bind="visible: filteredSections().length === 0, foreach: languages">
                        <div data-bind="if: $root.currentLanguage().id !== id">
                            <button data-bind="click: $root.copyFromLanguage" class="button-primary-border mb-1">Copy Sections from&nbsp;<span data-bind="text: name"></span></button>
                        </div>
                    </div>
                    <span data-bind="click: $root.addSection" class="admin-grid__add-section"><i class="fa fa-plus"></i> {{$lang['Add Section']}}</span>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div style="position: sticky; top: 0;" class="admin-box">
                    <div class="admin-box__header">
                        <h3 class="admin-box__title">{{$lang['Elements']}}</h3>
                        <a class="center-v-flex dif button-primary" target="_blank" href="/{{$curLang}}/admin/pagebuilder/create">{{$lang['Add new']}}</a>
                    </div>
                    <div class="mb-2">
                        <input data-bind="textInput: elementsFilterQuery" type="text" placeholder="Search Elements ..." class="form-input">
                    </div>
                    <div style="overflow-x: auto; max-height: 60vh;" data-bind="foreach: filteredElements" class="row">
                        <div class="col-6 admin-element-list-item-wrapper">
                            <div data-bind="draggable: {data: $data, options: {revert: 'invalid'}}" class="admin-element-list-item">
                                <span data-bind="css: item_type" class="admin-element-list-item__type"></span>
                                <span data-bind="text: item_name" class="admin-element-list-item__name"></span>
                            </div>
                        </div>
                    </div>
                    <div data-bind="visible: filteredElements().length === 0" class="empty-state">
                        <span class="empty-state__icon"><i class="fa fa-building-o"></i></span>
                        <div class="empty-state__text">{{$lang['No Elements']}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="pageid" value="{{$page['id']}}">
    <input type="hidden" id="defaultlanguageid" value="{{$settings['default_language_id']}}"> 
@stop