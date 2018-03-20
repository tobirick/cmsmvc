<div data-bind="visible: uploadPopupOpen" class="popup media-upload-popup">
    <div class="popup__container">
        <div class="popup__header">
            <h3 class="popup__title">Upload Media</h3>
            <span data-bind="click: $root.closePopup" class="popup__close"></span>
        </div>
        <div class="popup__content">
            <div class="row">
                <div data-bind="fileDrag: fileData" class="upload-zone">
                    <div class="upload-zone__container">
                        <div class="bigger">Drag your Files ...</div>
                        <div class="mb-1">or</div>
                        <label class="button-primary upload-zone__button" for="file">
                            <input id="file" multiple type="file" multiple data-bind="fileInput: fileData" accept="image/*">
                            Choose File
                        </label>
                    </div>
                </div>
                
                <div class="upload-zone__preview">
                    <img data-bind="attr: { src: fileData().dataURL }, visible: fileData().dataURL">
                </div>
            </div>
        </div>
    </div>
</div>