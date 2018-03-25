@extends('admin.partials.layout')
@section('title', 'Edit Theme')
@section('content-title')
{{$lang['Edit']}} '{{$theme['name']}}'
@stop

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/themes" class="button-primary-border">{{$lang['Go back']}}</a>
    @endslot
    @slot('right')
        <a data-bind="click: save" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div data-bind="visible: mediaPopupVM().mediaPopupOpen, click: mediaPopupVM().closeMediaPopup" class="popup__overlay"></div>
@include('admin.popups.media-images-overview-popup')
<div id="content">
@component('admin.components.alert')@endcomponent
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="admin-box no-padding popup__container">
               <div class="popup__header">
                  <h3 class="popup__title">Theme Settings for '{{$theme['name']}}'</h3>
               </div>
               <div data-bind="tabs: true" class="popup__tabs">
                     <ul>
                         <li data-tabsection="general" class="popup__tabs-item active">General</li>
                         <li data-tabsection="layout" class="popup__tabs-item">Layout</li>
                         <li data-tabsection="css" class="popup__tabs-item">CSS</li>
                         <li data-tabsection="integration" class="popup__tabs-item">Integration</li>
                     </ul>
                 </div>
               <div class="popup__content">

                  <div class="tab-content" id="general">
                     <div class="form-row">
                       <div class="col-3">
                          <label for="logo" class="form-label">Logo</label>
                       </div>
                       <div class="col-9">
                          <div class="center-v-flex">
                             <input data-bind="value: logo" type="text" id="logo" class="form-input">
                             <button data-bind="click: openMediaPopup.bind($data, logo)" class="ml-1 button-primary">Choose Logo</button>
                          </div>
                       </div>
                    </div>
                    <div class="form-row">
                       <div class="col-3">
                          <label for="favicon" class="form-label">Favicon</label>
                       </div>
                       <div class="col-9">
                          <div class="center-v-flex">
                             <input data-bind="value: favicon" type="text" id="favicon" class="form-input">
                             <button data-bind="click: openMediaPopup.bind($data, favicon)" class="ml-1 button-primary">Choose Favicon</button>
                          </div>
                       </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                           <label for="googlefont" class="form-label">Google Font</label>
                        </div>
                        <div class="col-9">
                              <input data-bind="value: google_font" type="text" id="googlefont" class="form-input">
                        </div>
                     </div>
                    <div class="form-row">
                       <div class="col-3">
                          <label for="googleanalytics" class="form-label">Google Analytics Code</label>
                       </div>
                       <div class="col-9">
                          <textarea data-bind="value: google_analytics" id="googleanalytics" class="form-input"></textarea>
                       </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                           <label for="to-top" class="form-label">Back to Top Button</label>
                        </div>
                        <div class="col-9">
                           <span class="form-checkbox">
                              <label for="to-top">
                                  <input data-bind="checked: to_top" class="form-checkbox__input" id="to-top" type="checkbox">
                                  <span class="form-checkbox__label">&nbsp;</span>
                              </label>
                          </span>
                        </div>
                     </div>

                  </div>

                  <div id="layout" class="tab-content">
                     <div class="popup__subsection">
                        <h3 class="popup__subtitle">Header</h3>
                        <div class="popup__subcontent">
                           <div class="form-row">
                              <div class="col-3">
                                 <label for="headerstyle" class="form-label">Header Style</label>
                              </div>
                              <div class="col-9">
                                 <select data-bind="options: headerStyles, value: header_layout" id="headerstyle" class="form-input"></select>
                              </div>
                           </div>
                        </div>
                        <div class="form-row">
                           <div class="col-3">
                              <label for="fixed-nav" class="form-label">Fixed Navigation Bar</label>
                           </div>
                           <div class="col-9">
                              <span class="form-checkbox">
                                 <label for="fixed-nav">
                                       <input data-bind="checked: fixed_navigation" class="form-checkbox__input" id="fixed-nav" type="checkbox">
                                       <span class="form-checkbox__label">&nbsp;</span>
                                 </label>
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="popup__subsection">
                        <h3 class="popup__subtitle">Footer</h3>
                        <div class="popup__subcontent">
                           <div class="form-row">
                              <div class="col-3">
                                 <label for="footercols" class="form-label">Footer Columns</label>
                              </div>
                              <div class="col-9">
                                 <button class="button-primary-icon dip" data-bind="click: removeFooterCol"><i class="fa fa-minus"></i></button>
                                 <span class="p-1" data-bind="text: footerColumns().length"></span>
                                 <button class="button-primary-icon dip" data-bind="click: addFooterCol"><i class="fa fa-plus"></i></button>
                              </div>
                           </div>
                           <div class="form-row">
                              <div class="df w-100" data-bind="sortable: {data: footerColumns, options: {revert: 'invalid'}}">
                                 <div class="w-100 draggable-footer-col">
                                    <div class="draggable-footer-col__footer-title"><span>Footer Column #</span><span data-bind="text: $index() + 1"></span></div>
                                    <div class="draggable-footer-col__title">
                                       <input type="text" placeholder="Footer Title" class="form-input" data-bind="value: title">
                                    </div>
                                    <div class="draggable-footer-col__html">
                                       <textarea placeholder="Footer HTML" class="form-input" data-bind="value: html"></textarea>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div id="css" class="tab-content">
                     <div class="form-row">
                       <div class="col-3">
                          <label for="css" class="form-label">Custom CSS</label>
                       </div>
                       <div class="col-9">
                          <textarea data-bind="value: css" id="css" class="form-input"></textarea>
                       </div>
                    </div>
                  </div>

                  <div id="integration" class="tab-content">
                     <div class="form-row">
                       <div class="col-3">
                          <label for="customstyles" class="form-label">Custom Stylesheets</label>
                       </div>
                       <div class="col-9">
                          <textarea data-bind="value: custom_styles" id="customstyles" class="form-input"></textarea>
                       </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                           <label for="customscripts" class="form-label">Custom Scripts</label>
                        </div>
                        <div class="col-9">
                           <textarea data-bind="value: custom_scripts" id="customscripts" class="form-input"></textarea>
                        </div>
                     </div>
                     <div class="form-row">
                       <div class="col-3">
                          <label for="headercode" class="form-label">Code for Header</label>
                       </div>
                       <div class="col-9">
                          <textarea data-bind="value: header_code" id="headercode" class="form-input"></textarea>
                       </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                           <label for="bodycode" class="form-label">Code for Body</label>
                        </div>
                        <div class="col-9">
                           <textarea data-bind="value: body_code" id="bodycode" class="form-input"></textarea>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
        </div>
    </div> 
</div>
<input type="hidden" id="themeid" value="{{$theme['id']}}">
@stop