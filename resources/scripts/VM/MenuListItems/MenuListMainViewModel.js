import ko from 'knockout';
import PageItemViewModel from '../Pages/PageItemViewModel';
import MenuItemViewModel from './MenuItemViewModel';
import PagesHandler from '../../Handlers/PagesHandler';
import MenuListItemsHandler from '../../Handlers/MenuListItemsHandler';

export default class MenuListMainViewModel {
    constructor() {
        this.menuListItems = ko.observableArray([]);
        this.pagesList = ko.observableArray([]);
        this.menuID = document.getElementById('menuid').value;
        this.csrfToken = document.getElementById('csrftoken');
        this.csrfTokenVal = document.getElementById('csrftoken').value;

        this.newMenuItemName = ko.observable(null);
        this.newMenuItemPage = ko.observable(null);

        this.getPages();
        this.getMenuListItems();
    }

    updateCSRF(newCsrfToken) {
        this.csrfTokenVal = newCsrfToken;
        this.csrfToken.value = newCsrfToken;
    }

    async getPages() {
        const data = await PagesHandler.loadPageItems();
        data.forEach((dataItem) => {
            const page = new PageItemViewModel(dataItem);
            this.pagesList.push(page);
        });
    }

    async getMenuListItems() {
        const data = await MenuListItemsHandler.loadMenuListItems(this.menuID)

        data.forEach((dataItem) => {
            const listItem = new MenuItemViewModel(dataItem, {
                deleteMenuListItem: this.deleteMenuListItem,
                updateMenuListItem: this.updateMenuListItem
            });
            this.menuListItems.push(listItem);
        });
    }

    async addMenuListItem() {
        const data = {
            menuitem: {
                name: this.newMenuItemName(),
                page: this.newMenuItemPage(),
            },
            csrf_token: this.csrfTokenVal
        }
        
        const response = await MenuListItemsHandler.handleAddMenuListItem(data, this.menuID);
        const listItem = new MenuItemViewModel(response.listItem, {
            deleteMenuListItem: this.deleteMenuListItem,
            updateMenuListItem: this.updateMenuListItem
        });

        this.menuListItems.push(listItem);
        this.updateCSRF(response.csrfToken);
    }

    updateMenuListItem = async (item) => {
        const data = {
            menuitem: {
                name: item.name(),
                page: item.page_id(),
            },
            csrf_token: this.csrfTokenVal
        }

        const response = await MenuListItemsHandler.handleUpdateMenuListItem(data, item.menu_id(), item.id());
        if(response.message === 'success') {
            this.updateCSRF(response.csrfToken);
        }
    }

    deleteMenuListItem = async (item) => {
        const data = {
            csrf_token: this.csrfTokenVal
        }

        const response = await MenuListItemsHandler.handleDeleteMenuListItem(data, item.menu_id(), item.id());
        if(response.message === 'success') {
            this.menuListItems.remove(item);
            this.updateCSRF(response.csrfToken);
        }
    }
}