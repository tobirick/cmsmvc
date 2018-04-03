<div data-bind="with: sectionSelected">
   <div style="display: none;" data-bind="visible: mediaPopupVM().mediaPopupOpen, click: mediaPopupVM().closeMediaPopup" class="popup__overlay higher-z"></div>
   @include('admin.popups.media-images-overview-popup')
</div>
<div style="display:none;" data-bind="visible: sectionSelected" class="popup pagebuilder-section-popup">
   <div data-bind="with: sectionSelected" class="popup__container">
      <div class="popup__header">
         <h3 class="popup__title">{{$lang['Section Settings']}} <span data-bind="visible: name">{{$lang['for']}} '<span data-bind="text: name"></span>'</span></h3>
         <span data-bind="click: $root.closeSettings" class="popup__close"></span>
      </div>
      <div data-bind="tabs: true" class="popup__tabs">
         <ul>
            <li data-tabsection="contenttab" class="popup__tabs-item active">Content</li>
            <li data-tabsection="designtab" class="popup__tabs-item">Design</li>
         </ul>
      </div>
      <div class="popup__content">
         <div class="tab-content" id="contenttab">
            <div class="popup__subsection">
               <h3 class="popup__subtitle">{{$lang['General Settings']}}</h3>
               <div class="popup__subcontent">
                  <div class="form-row">
                     <div class="col-3">
                        <label for="name" class="form-label">{{$lang['Name']}}</label>
                     </div>
                     <div class="col-9">
                        <input data-bind="textInput: name" type="text" id="name" class="form-input" placeholder="Section Name">
                     </div>
                  </div>
                  <div class="form-row">
                      <div class="col-3">
                          <label for="" class="form-label">Full width Section</label>
                      </div>
                      <div class="col-9">
                          <span class="form-checkbox">
                            <label for="full-width">
                                <input class="form-checkbox__input" id="full-width" type="checkbox" data-bind="checked: full_width">
                                <span class="form-checkbox__label">Yes</span>
                            </label>
                        </span>
                      </div>
                  </div>
               </div>
            </div>
            <div class="popup__subsection">
               <h3 class="popup__subtitle">Spacing</h3>
               <div class="popup__subcontent">
                  <div class="form-row">
                     <div class="col-3">
                        <label class="form-label">Padding</label>
                     </div>
                     <div class="col-9">
                        <div data-bind="with: paddingVM" class="row">
                           <div class="col-3">
                              <input data-bind="value: top" type="text" class="form-input" placeholder="0">
                           </div>
                           <div class="col-3">
                              <input data-bind="value: right" type="text" class="form-input" placeholder="0">
                           </div>
                           <div class="col-3">
                              <input data-bind="value: bottom" type="text" class="form-input" placeholder="0">
                           </div>
                           <div class="col-3">
                              <input data-bind="value: left" type="text" class="form-input" placeholder="0">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-row">
                     <div class="col-3">
                        <label class="form-label">Margin</label>
                     </div>
                     <div data-bind="with: marginVM" class="col-9">
                        <div class="row">
                           <div class="col-3">
                              <input data-bind="value: top" type="text" class="form-input" placeholder="0">
                           </div>
                           <div class="col-3">
                              <input data-bind="value: right" type="text" class="form-input" placeholder="0">
                           </div>
                           <div class="col-3">
                              <input data-bind="value: bottom" type="text" class="form-input" placeholder="0">
                           </div>
                           <div class="col-3">
                              <input data-bind="value: left" type="text" class="form-input" placeholder="0">
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
         </div>
         <div class="tab-content" id="designtab">
            <div class="popup__subsection">
               <h3 class="popup__subtitle">{{$lang['Background']}}</h3>
               <div class="popup__subcontent">
                  <div class="form-row">
                     <div class="col-3">
                        <label for="bgcolor" class="form-label">{{$lang['Background']}}</label>
                     </div>
                     <div class="col-9">
                         <div class="background-tabs">
                             <button data-bind="click: changeBackgroundMode.bind($data, 'color'), css:{active: current_bg_mode() === 'color'}"><i class="fa fa-paint-brush"></i></button>
                             <button data-bind="click: changeBackgroundMode.bind($data, 'image'), css:{active: current_bg_mode() === 'image'}"><i class="fa fa-image"></i></button>
                             <button data-bind="click: changeBackgroundMode.bind($data, 'gradient'), css:{active: current_bg_mode() === 'gradient'}"><i class="fa fa-exchange"></i></button>
                         </div>
                         <div data-bind="if: current_bg_mode() === 'gradient'">
                             <div data-bind="visible: bgGradient()" class="mt-2 mb-2">
                                <strong class="mb-1 dp">{{$lang['Gradient Preview']}}</strong>
                                <div data-bind="style:{backgroundImage: bgGradient()}" class="center-h-flex center-v-flex p-2" style="border: 1px solid #ddd; border-radius: 2px;height: 20rem;">
                                </div>
                             </div>
                            <div class="form-row">
                                <div class="col-6 center-v-flex">
                                    <input class="form-input" type="text" data-bind="colorPicker: bg_gradient_first_color">
                                    <input data-bind="textInput: bg_gradient_first_color, attr: {disabled: true}" type="text" id="bgcolor" class="form-input" placeholder="#f5f5f5">
                                </div>
                                <div class="col-6 center-v-flex">
                                    <input class="form-input" type="text" data-bind="colorPicker: bg_gradient_second_color">
                                    <input data-bind="textInput: bg_gradient_second_color, attr: {disabled: true}" type="text" id="bgcolor" class="form-input" placeholder="#f5f5f5">
                                </div>
                            </div>
                            <div class="form-row">
                                 <label for="gradienttype" class="form-label">Gradient Type</label>
                                 <select data-bind="options: bgGradientTypes, value: bg_gradient_type" id="gradienttype" class="form-input"></select>
                             </div>
                             <label class="form-label">Gradient Direction</label>
                             <div class="form-row">
                                 <div class="center-v-flex w-100">
                                     <input class="form-input" max="360" min="1" step="1" data-bind="value: bg_gradient_direction, valueUpdate: 'input', attr: {type: 'range', min: 1, max: 360, step: 1}">
                                     <span class="center-v-flex">
                                         <input style="margin: 0 1rem;" type="text" class="form-input" data-bind="value: bg_gradient_direction, valueUpdate: 'input', attr: {type: 'number', min: 1, max: 360, step: 1}">deg
                                     </span>
                                 </div>
                             </div>
                             <label class="form-label">Start Position</label>
                             <div class="form-row">
                                 <div class="center-v-flex w-100">
                                     <input class="form-input" max="100" min="0" step="1" data-bind="textInput: bg_gradient_start_position, attr: {type: 'range', min: 0, max: 100, step: 1}">
                                     <span class="center-v-flex">
                                         <input style="margin: 0 1rem;" type="text" class="form-input" data-bind="textInput: bg_gradient_start_position, attr: {type: 'number', min: 0, max: 100, step: 1}">%
                                     </span>
                                 </div>
                             </div>
                             <label class="form-label">End Position</label>
                             <div class="form-row">
                                 <div class="center-v-flex w-100">
                                     <input class="form-input" max="100" min="0" step="1" data-bind="textInput: bg_gradient_end_position, attr: {type: 'range', min: 0, max: 100, step: 1}">
                                     <span class="center-v-flex">
                                         <input style="margin: 0 1rem;" type="text" class="form-input" data-bind="textInput: bg_gradient_end_position, attr: {type: 'number', min: 0, max: 100, step: 1}">%
                                     </span>
                                 </div>
                             </div>
                         </div>
                         <div class="center-v-flex" data-bind="if: current_bg_mode() === 'color'">
                            <input class="form-input" type="text" data-bind="colorPicker: bg_color">
                             <input data-bind="textInput: bg_color, attr: {disabled: true}" type="text" id="bgcolor" class="form-input" placeholder="#f5f5f5">
                         </div>
                         <div data-bind="if: current_bg_mode() === 'image'">
                             <div class="center-v-flex">
                                <input data-bind="value: bg_image" type="text" id="bgimage" class="form-input" placeholder="Image URL">
                                <button data-bind="click: openMediaPopup" class="ml-1 button-primary">{{$lang['Choose Media']}}</button>
                             </div>                
                             <div data-bind="visible: bg_image" class="mt-2">
                                <strong class="mb-1 dp">{{$lang['Image Preview']}}</strong>
                                <div class="center-h-flex center-v-flex p-2" style="border: 1px solid #ddd; border-radius: 2px;">
                                   <img class="mw-100" data-bind="attr: {src: bg_image}">
                                </div>
                             </div>
                             <div class="form-row mt-2">
                                 <label for="imagesize" class="form-label">{{$lang['Background Image Size']}}</label>
                                 <select data-bind="options: bgImageSizeOptions, value: bg_image_size" id="imagesize" class="form-input"></select>
                             </div>
                             <div class="form-row">
                                 <label for="imageposition" class="form-label">{{$lang['Background Image Position']}}</label>
                                 <select data-bind="options: bgImagePositionOptions, value: bg_image_position"  id="imageposition" class="form-input"></select>
                             </div>
                             <div class="form-row">
                                 <label for="imagerepeat" class="form-label">{{$lang['Background Image Repeat']}}</label>
                                 <select data-bind="options: bgImageRepeatOptions, value: bg_image_repeat"  id="imagerepeat" class="form-input"></select>
                             </div>
                         </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="popup__subsection">
               <h3 class="popup__subtitle">CSS ID & {{$lang['Classes']}}</h3>
               <div class="popup__subcontent">
                  <div class="form-row">
                     <div class="col-3">
                        <label for="cssclass" class="form-label">CSS {{$lang['Class']}}</label>
                     </div>
                     <div class="col-9">
                        <input data-bind="value: css_class" type="text" id="cssclass" class="form-input" placeholder=".test">
                     </div>
                  </div>
                  <div class="form-row">
                     <div class="col-3">
                        <label for="cssid" class="form-label">CSS ID</label>
                     </div>
                     <div class="col-9">
                        <input data-bind="value: css_id" type="text" id="cssid" class="form-input" placeholder="#test">
                     </div>
                  </div>
               </div>
            </div>
            <div class="popup__subsection">
               <h3 class="popup__subtitle">{{$lang['Custom']}} CSS</h3>
               <div class="popup__subcontent">
                  <div class="form-row">
                     <div class="col-3">
                        <label for="customcss" class="form-label">{{$lang['Custom']}} CSS</label>
                     </div>
                     <div class="col-9">
                        <textarea data-bind="value: styles" id="customcss" class="form-input" placeholder="color: red;"></textarea>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>