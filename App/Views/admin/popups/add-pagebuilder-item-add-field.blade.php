<div data-bind="visible: popupOpen" class="popup popup--small media-add-folder-popup">
        <div data-bind="with: selectedField" class="popup__container">
            <div class="popup__header">
                <h3 class="popup__title">
                    <span data-bind="if: name">Update Field <span data-bind="text: name"></span></span>
                    <span data-bind="ifnot: name">Add Field</span>
                </h3>
                <span data-bind="click: $root.closePopup" class="popup__close"></span>
            </div>
            <div class="popup__content">
                <div class="popup__subsection">
               <h3 class="popup__subtitle">Field Settings</h3>
               <div class="popup__subcontent">
                  <div class="form-row">
                     <div class="col-3">
                        <label for="name" class="form-label">Name</label>
                     </div>
                     <div class="col-9">
                        <input data-bind="textInput: name" type="text" id="name" class="form-input" placeholder="Field Name">
                     </div>
                  </div>
                  <div class="form-row">
                        <div class="col-3">
                           <label for="name" class="form-label">Key</label>
                        </div>
                        <div class="col-9">
                           <input data-bind="textInput: key, attr:{disabled: true}" type="text" id="name" class="form-input" placeholder="Field Key">
                    </div>
                     </div>
                     <div class="form-row">
                        <div class="col-3">
                            <label for="name" class="form-label">Default Value</label>
                        </div>
                        <div class="col-9">
                            <input data-bind="value: value" type="text" id="name" class="form-input" placeholder="Default Value">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-3">
                            <label for="name" class="form-label">Field Type</label>
                        </div>
                        <div class="col-9">
                            <select class="form-input" data-bind="options: $root.possibleFieldTypes, value: type"></select>
                        </div>
                    </div>
               </div>
            </div>
            </div>
        </div>
    </div>