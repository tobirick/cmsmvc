import ko from 'knockout';
import UserRolesHandler from '../../Handlers/UserRolesHandler';
import csrf from '../../csrf';
import helpers from '../../helpers';

import PermissionViewModel from './PermissionViewModel';
import UserRoleViewModel from './UserRoleViewModel';

export default class UserRolesMainViewModel {
  constructor() {
    this.userRoles = ko.observableArray([]);
    this.selectedUserRole = ko.observable(null);

    this.userPermissions = ko.observableArray([]);

    this.newUserRoleName = ko.observable('');
    this.addUserRolePopupOpen = ko.observable(false)
  
    this.alert = ko.observable({
      visible: ko.observable(false),
      text: ko.observable(),
      type: ko.observable()
  });
}

  showAlert(type, message) {
    this.alert().visible(true);
    this.alert().type(type);
    this.alert().text(message);

    setTimeout(() => {
        this.alert().visible(false);
    }, 3000);
  }

  closeAlert = () => {
    this.alert().visible(false);
  }

  openAddUserRolePopup = () => {
    this.addUserRolePopupOpen(true);
  }

  closePopup = () => {
    this.addUserRolePopupOpen(false);
  }

  createUserRole = () => {
    const data = {
      csrf_token: csrf.getToken(),
      userRoleName: this.newUserRoleName()
    };

    UserRolesHandler.addUserRole(data).then(response => {
      csrf.updateToken(response.csrfToken);

      this.userRoles.push(this.addUserRole(response.userRole));

      this.showAlert('success', 'Role successfully added!');

      this.newUserRoleName('');
    })

  }

  checkAllPermissions = (userRole) => {
    const permissionIDs = this.userPermissions().map(userPermission => {
      return userPermission.id();
    });
    userRole.activePermissions(permissionIDs);
  }

  deleteUserRole = (userRole) => {
    if(userRole.is_admin()) {
      this.showAlert('error', 'You can\'t delete the Admin User Role!');
      return;
    }
    if(this.userRoles().length > 1 ) {
      const data = {
         csrf_token: csrf.getToken(),
         userRole: ko.toJS(userRole)
      }

      UserRolesHandler.deleteUserRole(data).then(response => {
         csrf.updateToken(response.csrfToken);
         this.showAlert('success', 'Role successfully deleted!');
         this.setSelectedUserRole(this.userRoles()[0]);

         this.userRoles.remove(userRole);
      });
    } else {
      this.showAlert('error', 'You need to have at least one User Role!');
    }
  }

  uncheckAllPermissions = (userRole) => {
    userRole.activePermissions([]);
  }

  saveToDB() {
    const data = {
      csrf_token: csrf.getToken(),
      userRoles: ko.toJS(this.userRoles)
    }

    UserRolesHandler.updateUserRoles(data).then(response => {
      csrf.updateToken(response.csrfToken);
      this.showAlert('success', 'Successfully saved User Roles!');
    });
  }

  addUserRole(data) {
    return new UserRoleViewModel(data, {
      checkAllPermissions: this.checkAllPermissions,
      uncheckAllPermissions: this.uncheckAllPermissions,
      deleteUserRole: this.deleteUserRole
    });
  }

  addUserPermission(data) {
    return new PermissionViewModel(data, {});
  }

  setSelectedUserRole = (role) => {
    this.selectedUserRole(role);
  }

  fetchUserRoles() {
    const data = {
      csrf_token: csrf.getToken()
    }

    return UserRolesHandler.fetchUserRoles(data).then(async response => {
      csrf.updateToken(response.csrfToken);
      for(let userRole of response.userRoles) {
        const newRole = this.addUserRole(userRole);
        await newRole.fetchActivePermissions();
        this.userRoles.push(newRole);
      }
      this.setSelectedUserRole(this.userRoles()[0]);
    });
   }

   fetchUserPermissions() {
    const data = {
      csrf_token: csrf.getToken()
    }

    return UserRolesHandler.fetchUserPermissions(data).then(response => {
      csrf.updateToken(response.csrfToken);
      response.permissions.forEach(permission => {
        this.userPermissions.push(this.addUserPermission(permission));
      });
    });
  }
}