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
<div style="display: none;" data-bind="visible: mediaPopupVM().mediaPopupOpen, click: mediaPopupVM().closeMediaPopup" class="popup__overlay"></div>
@include('admin.popups.media-images-overview-popup')
<div id="content">
@component('admin.components.alert')@endcomponent
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="admin-box no-padding popup__container">
               <div class="popup__header">
                  <h3 class="popup__title">{{$lang['Theme Settings']}} {{$lang['for']}} '{{$theme['name']}}'</h3>
               </div>
               <div data-bind="tabs: true" class="popup__tabs">
                     <ul>
                         <li data-tabsection="general" class="popup__tabs-item active">General</li>
                         <li data-tabsection="layout" class="popup__tabs-item">Layout</li>
                         <li data-tabsection="typography" class="popup__tabs-item">Typography</li>
                         <li data-tabsection="css" class="popup__tabs-item">CSS</li>
                         <li data-tabsection="integration" class="popup__tabs-item">Integration</li>
                     </ul>
                 </div>
               <div class="popup__content no-scroll">

                  <div class="tab-content" id="general">
                     <div class="form-row">
                       <div class="col-3">
                          <label for="logo" class="form-label">Logo</label>
                       </div>
                       <div class="col-9">
                          <div class="center-v-flex">
                             <input data-bind="value: logo" type="text" id="logo" class="form-input">
                             <button data-bind="click: openMediaPopup.bind($data, logo)" class="ml-1 button-primary">{{$lang['Choose']}} Logo</button>
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
                             <button data-bind="click: openMediaPopup.bind($data, favicon)" class="ml-1 button-primary">{{$lang['Choose']}} Favicon</button>
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
                     <div class="form-row">
                        <div class="col-3">
                           <label for="defaultcolor" class="form-label">{{$lang['Default Color']}}</label>
                        </div>
                        <div class="col-9 center-v-flex">
                           <input id="defaultcolor" class="form-input" type="text" data-bind="colorPicker: default_color">
                           <input data-bind="textInput: default_color, attr: {disabled: true}" type="text" class="form-input">
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

                  <div id="typography" class="tab-content">
                    <div data-bind="with: body" class="popup__subsection">
                        <h3 class="popup__subtitle">Body</h3>
                        <div class="popup__subcontent">
                            <div class="form-row">
                               <div class="col-3">
                                  <label for="bodysize" class="form-label">Body Text {{$lang['Size']}}</label>
                               </div>
                               <div class="col-9 center-v-flex">
                                  <input max="10" min="1" step="0.1" data-bind="textInput: font_size, attr:{min: 1, max: 10, step: .1}" class="form-input" type="range">
                                  <span class="center-v-flex">
                                     <input data-bind="textInput: font_size, attr:{min: 1, max: 10, step: .1, type: 'number'}" id="bodysize" style="margin: 0 1rem;" class="form-input">rem
                                  </span>
                               </div>
                            </div>
                            <div class="form-row">
                               <div class="col-3">
                                  <label for="bodylineheight" class="form-label">Body Line Height</label>
                               </div>
                               <div class="col-9 center-v-flex">
                                  <input max="3" min="0.8" step="0.1" data-bind="textInput: line_height, attr:{min: 0.8, max: 3, step: .1}" class="form-input" type="range">
                                  <span class="center-v-flex">
                                     <input data-bind="textInput: line_height, attr:{min: 0.8, max: 3, step: .1, type: 'number'}" id="bodylineheight" style="margin: 0 1rem;" class="form-input">
                                  </span>
                               </div>
                            </div>
                            <div class="form-row">
                                <div class="col-3">
                                    <label for="bodyletterspacing" class="form-label">Body Letter Spacing</label>
                                </div>
                               <div class="col-9 center-v-flex">
                                  <input max="10" min="-2" step="1" data-bind="textInput: letter_spacing, attr:{min: -2, max: 10, step: 1}" class="form-input" type="range">
                                  <span class="center-v-flex">
                                     <input data-bind="textInput: letter_spacing, attr:{min: -2, max: 10, step: 1, type: 'number'}" id="bodyletterspacing" style="margin: 0 1rem;" class="form-input">
                                  </span>
                               </div>
                            </div>
                            <div class="form-row">
                               <div class="col-3">
                                  <label for="bodyfamily" class="form-label">Body Font Family</label>
                               </div>
                               <div class="col-9">
                                  <select data-bind="options: $parent.possibleFontFamilies, value: font_family" class="form-input" id="bodyfamily">
                                  </select>
                               </div>
                            </div>
                            <div class="form-row">
                               <div class="col-3">
                                  <label for="bodycolor" class="form-label">Body Text {{$lang['Color']}}</label>
                               </div>
                               <div class="col-9 center-v-flex">
                                  <input id="bodycolor" class="form-input" type="text" data-bind="colorPicker: color">
                                  <input data-bind="textInput: color, attr:{disabled: true}" type="text" class="form-input">
                               </div>
                            </div>
                        </div>
                    </div>

                    <div class="popup__subsection">
                        <h3 class="popup__subtitle">Headings</h3>
                        <div class="popup__subcontent">
                            <div data-bind="with: h1" class="form-row">
                               <div class="col-3">
                                  <label for="h1size" class="form-label">H1 Text {{$lang['Size']}}</label>
                               </div>
                               <div class="col-9 center-v-flex">
                                  <input max="10" min="1" step="0.1" data-bind="textInput: font_size, attr:{min: 1, max: 10, step: .1}" id="h1size" class="form-input" type="range">
                                  <span class="center-v-flex">
                                     <input data-bind="textInput: font_size, attr:{min: 1, max: 10, step: .1, type: 'number'}" style="margin: 0 1rem;" class="form-input">rem
                                  </span>
                               </div>
                            </div>
                            <div data-bind="with: h2" class="form-row">
                               <div class="col-3">
                                  <label for="h2size" class="form-label">H2 Text {{$lang['Size']}}</label>
                               </div>
                               <div class="col-9 center-v-flex">
                                  <input max="10" min="1" step="0.1" data-bind="textInput: font_size, attr:{min: 1, max: 10, step: .1}" id="h2size" class="form-input" type="range">
                                  <span class="center-v-flex">
                                     <input data-bind="textInput: font_size, attr:{min: 1, max: 10, step: .1, type: 'number'}" style="margin: 0 1rem;" class="form-input">rem
                                  </span>
                               </div>
                            </div>
                            <div data-bind="with: h3" class="form-row">
                               <div class="col-3">
                                  <label for="h3size" class="form-label">H3 Text {{$lang['Size']}}</label>
                               </div>
                               <div class="col-9 center-v-flex">
                                  <input max="10" min="1" step="0.1" data-bind="textInput: font_size, attr:{min: 1, max: 10, step: .1}" id="h3size" class="form-input" type="range">
                                  <span class="center-v-flex">
                                     <input data-bind="textInput: font_size, attr:{min: 1, max: 10, step: .1, type: 'number'}" style="margin: 0 1rem;" class="form-input">rem
                                  </span>
                               </div>
                            </div>
                            <div data-bind="with: h4" class="form-row">
                               <div class="col-3">
                                  <label for="h4size" class="form-label">H4 Text {{$lang['Size']}}</label>
                               </div>
                               <div class="col-9 center-v-flex">
                                  <input max="10" min="1" step="0.1" data-bind="textInput: font_size, attr:{min: 1, max: 10, step: .1}" id="h4size" class="form-input" type="range">
                                  <span class="center-v-flex">
                                     <input data-bind="textInput: font_size, attr:{min: 1, max: 10, step: .1, type: 'number'}" style="margin: 0 1rem;" class="form-input">rem
                                  </span>
                               </div>
                            </div>
                            <div class="form-row">
                               <div class="col-3">
                                  <label for="headinglineheight" class="form-label">Heading Line Height</label>
                               </div>
                               <div class="col-9 center-v-flex">
                                  <input max="3" min="0.8" step="0.1" data-bind="textInput: headingLineHeight, attr:{min: 0.8, max: 3, step: .1}" class="form-input" type="range">
                                  <span class="center-v-flex">
                                     <input data-bind="textInput: headingLineHeight, attr:{min: 0.8, max: 3, step: .1, type: 'number'}" id="headinglineheight" style="margin: 0 1rem;" class="form-input">
                                  </span>
                               </div>
                            </div>
                            <div class="form-row">
                                <div class="col-3">
                                    <label for="headingletterspacing" class="form-label">Heading Letter Spacing</label>
                                </div>
                               <div class="col-9 center-v-flex">
                                  <input max="10" min="-2" step="1" data-bind="textInput: headingLetterSpacing, attr:{min: -2, max: 10, step: 1}" class="form-input" type="range">
                                  <span class="center-v-flex">
                                     <input data-bind="textInput: headingLetterSpacing, attr:{min: -2, max: 10, step: 1, type: 'number'}" id="headingletterspacing" style="margin: 0 1rem;" class="form-input">
                                  </span>
                               </div>
                            </div>
                            <div class="form-row">
                               <div class="col-3">
                                  <label for="hfamily" class="form-label">Heading Font Family</label>
                               </div>
                               <div class="col-9">
                                  <select data-bind="value: headingFontFamily, options: possibleFontFamilies" class="form-input" id="hfamily">
                                  </select>
                               </div>
                            </div>                     
                            <div class="form-row">
                               <div class="col-3">
                                  <label for="hcolor" class="form-label">Heading Text {{$lang['Color']}}</label>
                               </div>
                               <div class="col-9 center-v-flex">
                                  <input id="hcolor" class="form-input" type="text" data-bind="colorPicker: headingColor">
                                  <input data-bind="textInput: headingColor, attr:{disabled: true}" type="text" class="form-input">
                               </div>
                            </div>
                         </div>
                        </div>
                    </div>
       
                         <div id="css" class="tab-content">
                            <div class="form-row">
                              <div class="col-3">
                                 <label for="css" class="form-label">{{$lang['Custom']}} CSS</label>
                              </div>
                              <div class="col-9">
                                 <textarea data-bind="value: css" id="css" class="form-input"></textarea>
                              </div>
                           </div>
                         </div>
       
                         <div id="integration" class="tab-content">
                            <div class="form-row">
                              <div class="col-3">
                                 <label for="customstyles" class="form-label">{{$lang['Custom']}} Stylesheets</label>
                              </div>
                              <div class="col-9">
                                 <textarea data-bind="value: custom_styles" id="customstyles" class="form-input"></textarea>
                              </div>
                           </div>
                           <div class="form-row">
                               <div class="col-3">
                                  <label for="customscripts" class="form-label">{{$lang['Custom']}} Scripts</label>
                               </div>
                               <div class="col-9">
                                  <textarea data-bind="value: custom_scripts" id="customscripts" class="form-input"></textarea>
                               </div>
                            </div>
                            <div class="form-row">
                              <div class="col-3">
                                 <label for="headercode" class="form-label">Code {{$lang['for']}} Header</label>
                              </div>
                              <div class="col-9">
                                 <textarea data-bind="value: header_code" id="headercode" class="form-input"></textarea>
                              </div>
                           </div>
                           <div class="form-row">
                               <div class="col-3">
                                  <label for="bodycode" class="form-label">Code {{$lang['for']}} Body</label>
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
    </div> 
</div>
<input type="hidden" id="themeid" value="{{$theme['id']}}">
@stop