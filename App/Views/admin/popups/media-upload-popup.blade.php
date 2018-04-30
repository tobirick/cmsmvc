<div style="display:none;" data-bind="visible: uploadPopupOpen" class="popup media-upload-popup">
    <div class="popup__container">
        <div class="popup__header">
            <h3 class="popup__title">{{$lang['Upload Image']}}</h3>
            <span data-bind="click: $root.closePopup" class="popup__close"></span>
        </div>
        <div class="popup__content">
            <div class="row">
                <div data-bind="fileDrag: fileData" class="upload-zone">
                    <div class="upload-zone__container">
                        <div class="bigger">{{$lang['Drag your Files']}}</div>
                        <div class="mb-1">{{$lang['or']}}</div>
                        <label class="button-primary upload-zone__button" for="file">
                            <input id="file" multiple type="file" multiple data-bind="fileInput: fileData" accept="image/*">
                            {{$lang['Choose File']}}
                        </label>
                    </div>
                </div>
                
                <div class="upload-zone__preview">
                    <div data-bind="foreach: imagePreviews">
                        <img data-bind="attr: { src: $data }">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>