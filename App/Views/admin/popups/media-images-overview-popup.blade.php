<div style="display:none;" data-bind="visible: mediaPopupVM().mediaPopupOpen, with: mediaPopupVM()" class="popup pagebuilder-media-overview-popup higher-z">
        <div class="popup__container">
            <div class="popup__header">
                <h3 class="popup__title">Choose your Image</h3>
                <span data-bind="click: closeMediaPopup" class="popup__close"></span>
            </div>
            <div class="popup__content">
                <div class="row">
                    <div class="col-8">
                        <div data-bind="foreach: mediaElements" class="images-preview">
                            <div data-bind="click: $parent.setMediaElement, css: {active: $parent.selectedMediaElement() && $parent.selectedMediaElement().id === id}" class="images-preview__item">
                                <img data-bind="attr: {src: '/content/media' + path + name}">
                            </div>
                        </div>
                    </div>
                    <div class="active-media-element col-4 empty" data-bind="visible: !selectedMediaElement()">
                        <span>&nbsp;</span>
                        <span>&nbsp;</span>
                        <span>&nbsp;</span>
                    </div>
                    <div data-bind="with: selectedMediaElement, visible: selectedMediaElement()" class="col-4 active-media-element">
                        <div class="form-row">
                            <div class="col-3">
                                <label class="form-label" id="name">Name</label>
                            </div>
                            <div class="col-9">
                                <input id="name" type="text" class="form-input" data-bind="value: name, attr: {disabled: true}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-3">
                                <label class="form-label" id="path">Path</label>
                            </div>
                            <div class="col-9">
                                <input id="path" type="text" class="form-input" data-bind="value: '/content/media' + path + name, attr: {disabled: true}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-3">
                                <label class="form-label" id="size">Size</label>
                            </div>
                            <div class="col-9">
                                <input id="size" type="text" class="form-input" data-bind="value: size, attr: {disabled: true}">
                            </div>
                        </div>
                    </div>
                </div>
          </div>
       </div>
    </div>