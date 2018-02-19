import ko from 'knockout';

export default class MenuListItemsViewModel {
    constructor(data) {
        for(let key in data) {
            this[key] = data[key];
        }
    }

    addMenuListItem() {

    }

    delteMenuListItem() {

    }

    updateMenuListItem() {

    }
}