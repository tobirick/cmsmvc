<div data-bind="if: sectionSelected" class="popup pagebuilder-section-popup">
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
                Content
            </div>
             <div class="tab-content" id="designtab">
                Design
            </div>
        </div>
    </div>
</div>