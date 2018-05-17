<div style="display:none;" data-bind="visible: $root.mediaPopupVM().mediaPopupOpen, with: $root.mediaPopupVM()" class="popup pagebuilder-media-overview-popup higher-z">
        <div class="popup__container">
            <div class="popup__header">
                <h3 class="popup__title">{{$lang['Choose Image']}}</h3>
                <button style="margin-right: auto; margin-left: 2rem;" class="button-primary">Upload Image</button>
                <span data-bind="click: closeMediaPopup" class="popup__close"></span>
            </div>
            <div class="popup__content">
                <div class="row mb-2 center-v-flex">
                    <div class="col-7">
                        <input type="text" class="form-input" placeholder="Search for name or path ..." data-bind="textInput: filterQuery">
                    </div>
                    <div class="col-5">
                        <span class="form-checkbox">
                            <label for="exclude-media-images">
                                <input class="form-checkbox__input" id="exclude-media-images" type="checkbox" data-bind="checked: excludeMediaImages">
                                <span class="form-checkbox__label">Exclude Media Images (@2x, @3x)</span>
                            </label>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div data-bind="visible: filteredMediaElements().length === 0" class="empty-state">
                            <span class="empty-state__icon"><i class="fa fa-image"></i></span>
                            <div class="empty-state__text">No Images</div>
                        </div>
                        <div data-bind="foreach: filteredMediaElements" class="images-preview">
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
                                <label class="form-label" id="name">{{$lang['Name']}}</label>
                            </div>
                            <div class="col-9">
                                <input id="name" type="text" class="form-input" data-bind="value: name, attr: {disabled: true}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-3">
                                <label class="form-label" id="path">{{$lang['Path']}}</label>
                            </div>
                            <div class="col-9">
                                <input id="path" type="text" class="form-input" data-bind="value: '/content/media' + path + name, attr: {disabled: true}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-3">
                                <label class="form-label" id="size">{{$lang['Size']}}</label>
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