import ko from 'knockout';

export default class MenuItemViewModel {
    constructor(data, delegates) {
        for (let key in data) {
            this[key] = ko.observable(data[key]);
        }

        this.deleteMenuListItem = delegates.deleteMenuListItem;
        this.updateMenuListItem = delegates.updateMenuListItem;
    }
}