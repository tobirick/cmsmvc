import ko from 'knockout';

export default class PermissionViewModel {
  constructor(data, delegates) {
    this.id = ko.observable(data.id || '');
    this.permission_name = ko.observable(data.permission_name || '');
  }
}