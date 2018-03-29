<div style="display:none;"  data-bind="visible: addUserRolePopupOpen" class="popup popup--small user-roles-add-role-popup">
    <div class="popup__container">
        <div class="popup__header">
            <h3 class="popup__title">Add User Role</h3>
            <span data-bind="click: $root.closePopup" class="popup__close"></span>
        </div>
        <div class="popup__content">
            <div class="row">
                <div class="col-10">
                    <input data-bind="value: newUserRoleName" type="text" placeholder="Role Name" class="form-input">
                </div>
                <div class="col-2 center-v-flex">
                    <button data-bind="click: $root.createUserRole" class="button-primary block">Create</button>
                </div>
            </div>
        </div>
    </div>
</div>