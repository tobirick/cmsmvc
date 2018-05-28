<div style="display:none;" data-bind="visible: elementSelected" class="popup pagebuilder-element-popup">
    <div data-bind="with: elementSelected" class="popup__container">
        <div class="popup__header">
            <h3 class="popup__title">{{$lang['Element Settings']}} <span data-bind="visible: name">{{$lang['for']}} '<span data-bind="text: name"></span>'</span></h3>
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
                <div data-bind="foreach: config().elements()">
                    <div class="form-row">
                        <div class="col-3">
                            <label class="form-label" data-bind="text: name, attr:{for: key}"></label>
                        </div>
                        <div class="col-9">
                            <div data-bind="if: type() === 'image-src' || type() === 'responsive-image-src'">
                                <div class="center-v-flex">
                                    <input type="text" class="form-input" data-bind="textInput: value, attr:{id: key, placeholder: name}">
                                    <button data-bind="click: $root.openMediaPopup" class="ml-1 button-primary">{{$lang['Choose Media']}}</button>
                                </div>
                                <div data-bind="visible: value" class="mt-2">
                                    <strong class="mb-1 dp">{{$lang['Image Preview']}}</strong>
                                    <div class="center-h-flex center-v-flex p-2" style="border: 1px solid #ddd; border-radius: 2px;">
                                       <img class="mw-100" data-bind="attr: {src: value}">
                                    </div>
                                 </div>
                            </div>
                            <div data-bind="if: type() === 'textarea'">
                                <div data-bind="quill: value"></div>
                            </div>
                            <div class="center-v-flex" data-bind="if: type() === 'text' || type() === 'range' || type() === 'number'">
                                <input class="form-input" max="10" min="1" step="0.1" data-bind="textInput: value, attr:{id: key, placeholder: name, type: type, min: 1, max: 10, step: 0.1}">
                                <span class="center-v-flex" data-bind="if: type() === 'range'">
                                    <input style="margin: 0 1rem;" type="text" class="form-input" data-bind="textInput: value, attr: {type: 'number', min: 1, max: 10, step: 0.1}">rem
                                </span>
                            </div>
                            <div class="center-v-flex" data-bind="if: type() === 'color'">                          
                                 <input class="form-input" type="text" data-bind="colorPicker: value, attr:{id: key, placeholder: name}">
                                 <input type="text" class="form-input" data-bind="textInput: value, attr:{disabled: true}">
                            </div>
                            <div data-bind="if: type() === 'button-row'">
                                <div data-bind="foreach: buttons">
                                    <button data-bind="click: $parents[1].toggleButtonStatus, css: {disabled: !enabled()}" class="button-primary">
                                       <span data-bind="if: icon().includes('fa')"></span><i data-bind="css: icon()"></i>
                                       <span data-bind="ifnot: icon().includes('fa')"><span data-bind="text: icon()"></span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup__subsection">
               <h3 class="popup__subtitle">{{$lang['General Settings']}}</h3>
               <div class="popup__subcontent">
                  <div class="form-row">
                     <div class="col-3">
                        <label for="name" class="form-label">{{$lang['Name']}}</label>
                     </div>
                     <div class="col-9">
                        <input data-bind="textInput: name" type="text" id="name" class="form-input" placeholder="Element Name">
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
                        <label for="bgcolor" class="form-label">{{$lang['Background Color']}}</label>
                     </div>
                     <div class="col-9">
                        <input data-bind="value: bg_color" type="text" id="bgcolor" class="form-input" placeholder="#f5f5f5">
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