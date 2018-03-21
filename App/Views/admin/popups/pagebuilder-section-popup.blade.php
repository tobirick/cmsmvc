<div data-bind="visible: sectionSelected" class="popup pagebuilder-section-popup">
   <div data-bind="with: sectionSelected" class="popup__container">
      <div class="popup__header">
         <h3 class="popup__title">Section Settings</h3>
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
               <h3 class="popup__subtitle">General Settings</h3>
               <div class="popup__subcontent">
                  <div class="form-row">
                     <div class="col-3">
                        <label for="name" class="form-label">Name</label>
                     </div>
                     <div class="col-9">
                        <input data-bind="value: name" type="text" id="name" class="form-input" placeholder="Section Name">
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
               <h3 class="popup__subtitle">Background</h3>
               <div class="popup__subcontent">
                  <div class="form-row">
                     <div class="col-3">
                        <label for="bgcolor" class="form-label">Background Color</label>
                     </div>
                     <div class="col-9">
                        <input data-bind="value: bg_color" type="text" id="bgcolor" class="form-input" placeholder="#f5f5f5">
                     </div>
                  </div>
               </div>
            </div>
            <div class="popup__subsection">
               <h3 class="popup__subtitle">CSS ID & Classes</h3>
               <div class="popup__subcontent">
                  <div class="form-row">
                     <div class="col-3">
                        <label for="cssclass" class="form-label">CSS Class</label>
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
               <h3 class="popup__subtitle">Custom CSS</h3>
               <div class="popup__subcontent">
                  <div class="form-row">
                     <div class="col-3">
                        <label for="customcss" class="form-label">Custom CSS</label>
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