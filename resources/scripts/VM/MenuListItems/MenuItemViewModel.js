import ko from 'knockout';

export default class MenuItemViewModel {
    constructor(data, delegates) {
        for(let key in data) {
            this[key] = ko.observable(data[key]);
        }   

        this.page_id.subscribe(id => {
            this.page_id(id);
        });

        this.name.subscribe(val => {
            this.name(val);
        });

        this.css_class.subscribe(val => {
            this.css_class(val);
        });

        this.deleteMenuListItem = delegates.deleteMenuListItem;
        this.updateMenuListItem = delegates.updateMenuListItem;
    }
}