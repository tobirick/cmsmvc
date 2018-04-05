<div style="display:none;"  data-bind="visible: addTranslationPopupOpen" class="popup popup--small add-translation-popup">
    <div class="popup__container">
        <div class="popup__header">
            <h3 class="popup__title">{{$lang['Add Translation']}}</h3>
            <span data-bind="click: $root.closePopup" class="popup__close"></span>
        </div>
        <div class="popup__content">
            <div class="row">
                <div class="col-10">
                    <input data-bind="value: newTranslationKey" type="text" placeholder="Translation Key" class="form-input">
                </div>
                <div class="col-2 center-v-flex">
                    <button data-bind="click: $root.createTranslation" class="button-primary block">{{$lang['Create']}}</button>
                </div>
            </div>
        </div>
    </div>
</div>