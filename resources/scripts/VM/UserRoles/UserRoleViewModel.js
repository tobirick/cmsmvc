import ko from 'knockout';
import UserRolesHandler from '../../Handlers/UserRolesHandler';
import csrf from '../../csrf';

export default class UserRoleViewModel {
  constructor(data, delegates) {
    this.id = ko.observable(data.id || '');
    this.user_role_name = ko.observable(data.user_role_name || '');
    this.is_admin = ko.observable(!!parseInt(data.is_admin) || false);
    this.activePermissions = ko.observableArray([]);

    this.checkAllPermissions = delegates.checkAllPermissions;
    this.uncheckAllPermissions = delegates.uncheckAllPermissions;
    this.deleteUserRole = delegates.deleteUserRole;
  }

  toggleCheckbox = (permission) => {
    if(this.activePermissions().indexOf(permission.id()) !== -1) {
      this.activePermissions.remove(permission.id());
    } else {
      this.activePermissions.push(permission.id());
    }
  }

  async fetchActivePermissions() {
    const data = {
      csrf_token: csrf.getToken(),
      id: this.id()
    }

    const response = await UserRolesHandler.fetchActivePermissions(data);

    if(response) {
      csrf.updateToken(response.csrfToken);
      response.IDs.forEach(ID => {
        this.activePermissions.push(ID);
      });
    }
  }
}