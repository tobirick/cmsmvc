<div data-bind="visible: uploadPopupOpen" class="popup media-upload-popup">
    <div class="popup__container">
        <div class="popup__header">
            <h3 class="popup__title">Upload Media</h3>
            <span data-bind="click: $root.closePopup" class="popup__close"></span>
        </div>
        <div class="popup__content">
            <div class="row">
                <div data-bind="event: {drop: $root.uploadFile}" class="upload-zone">
                    <div class="upload-zone__container">
                        <div class="bigger">Drag your Files ...</div>
                        <div class="mb-1">or</div>
                        <button class="button-primary">Choose File</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>