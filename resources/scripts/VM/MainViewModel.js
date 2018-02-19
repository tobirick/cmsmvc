import ko from 'knockout';
import PageItemViewModel from './PageItemViewModel';
import MenuListItemViewModel from './MenuListItemViewModel';

class MainViewModel {
    constructor() {
        this.menuListItems = ko.observableArray([]);
        this.pagesList = ko.observableArray([]);

        this.loadPageItems();
        this.loadMenuListItems(2);
    }

    async loadPageItems() {
        const url = `/pages`;
        const response = await fetch(url, {
            method: 'POST',
            credentials: 'include'
        });

        const data = await response.json();

        data.forEach((dataItem) => {
            const page = new PageItemViewModel(dataItem);
            this.pagesList.push(page);
        });
    }

    async loadMenuListItems(id) {
        const url = `/admin/menus/${id}/menuitems`;
        const response = await fetch(url, {
            method: 'GET',
            credentials: 'include'
        });

        const data = await response.json();

        data.forEach((dataItem) => {
            const listItem = new MenuListItemViewModel(dataItem);
            this.menuListItems.push(listItem);
        });
    }
}

export default new MainViewModel();