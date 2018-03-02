<div data-bind="if: elementSelected" class="popup pagebuilder-element-popup">
    <div data-bind="with: elementSelected" class="popup__container">
        <div class="popup__header">
            <h3 class="popup__title">Element Settings</h3>
            <span data-bind="click: $root.closeSettings" class="popup__close"></span>
        </div>
        <div class="popup__tabs">
            <ul>
                <li class="popup__tabs-item active">Content</li>
                <li class="popup__tabs-item">Design</li>
            </ul>
        </div>
        <div class="popup__content">
            hello from the popup my friend
        </div>
    </div>
</div>