<div data-bind="visible: folderPopupOpen" class="popup popup--small media-add-folder-popup">
    <div class="popup__container">
        <div class="popup__header">
            <h3 class="popup__title">Add Folder</h3>
            <span data-bind="click: $root.closePopup" class="popup__close"></span>
        </div>
        <div class="popup__content">
            <div class="row">
                <div class="col-10">
                    <input data-bind="value: newFolderName" type="text" placeholder="Folder Name" class="form-input">
                </div>
                <div class="col-2">
                    <button data-bind="click: $root.createFolder" class="button-primary block">Create</button>
                </div>
            </div>
        </div>
    </div>
</div>