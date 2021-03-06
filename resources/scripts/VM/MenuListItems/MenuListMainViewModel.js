import ko from 'knockout';
import csrf from '../../csrf';

import PageItemViewModel from '../Pages/PageItemViewModel';
import MenuItemViewModel from './MenuItemViewModel';
import PagesHandler from '../../Handlers/PagesHandler';
import MenuListItemsHandler from '../../Handlers/MenuListItemsHandler';
import LanguagesHandler from '../../Handlers/LanguagesHandler';

export default class MenuListMainViewModel {
    constructor() {
        this.menuID = document.getElementById('menuid').value;
        this.defaultData = {
            id: '',
            name: '',
            menu_id: this.menuID,
            page_id: 0,
            menu_position: 0,
            css_class: '',
            link_to: '',
            subListItems: []
        };
        this.menuListItems = ko.observableArray([]);
        this.pagesList = ko.observableArray([]);

        this.filteredMenuItems = ko.observableArray([]);

        this.newMenuItem = this.newMenuItemModel(this.defaultData);

        this.languages = ko.observableArray([]);
        this.currentLanguage = ko.observable(null);

        this.menuListItems.subscribe(() => {
            this.filterMenuItems(this.currentLanguage());
        });
    }

    fetchLanguages() {
        const data = {
            csrf_token: csrf.getToken(),
        };

        return LanguagesHandler.fetchLanguages(data).then((response) => {
            csrf.updateToken(response.csrfToken);
            response.languages.forEach(language => {
                this.languages.push(language);
            });
            this.currentLanguage(this.languages()[0]);
        });
    }

    resetNewMenuItem() {
        for (let key in this.newMenuItem) {
            if (ko.isObservable(this.newMenuItem[key])) {
                if (key !== 'menu_id') this.newMenuItem[key]('');
            }
        }
    }

    async updateMenuPositions() {
        console.log(ko.toJS(this.filteredMenuItems));
        this.filteredMenuItems().forEach((menuListItem, position) => {
            menuListItem.menu_position(position);
            if(menuListItem.subListItems().length > 0) {
                menuListItem.subListItems().forEach((subListItem, position) => {
                    subListItem.menu_position(position);
                });
            }
        });

        const data = {
            csrf_token: csrf.getToken(),
            menuitems: ko.toJS(this.filteredMenuItems)
        };

        const response = await MenuListItemsHandler.handleUpdateMenuListItemPositions(
            data,
            this.menuID
        );

        csrf.updateToken(response.csrfToken);
    }

    getPages() {
        return PagesHandler.loadPageItems().then(response => {
            response.forEach(dataItem => {
                this.pagesList.push(new PageItemViewModel(dataItem));
            });
        });
    }

    getMenuListItems() {
        return MenuListItemsHandler.loadMenuListItems(this.menuID).then(response => {
            response.forEach(dataItem => {
                const newMenuItem = this.newMenuItemModel(dataItem);
                if(dataItem.subListItems) {
                    newMenuItem.subListItems = ko.observableArray([]);
                    dataItem.subListItems.forEach(subListItem => {
                        newMenuItem.subListItems.push(this.newMenuItemModel(subListItem));
                    });
                }
                this.menuListItems.push(newMenuItem);
            });
        });
    }

    async addMenuListItem() {
        const data = {
            menuitem: {
                ...ko.toJS(this.newMenuItem),
                type: 'page',
                menu_position: ko.toJS(this.menuListItems).length,
                language_id: this.currentLanguage().id
            },
            csrf_token: csrf.getToken()
        };

        MenuListItemsHandler.handleAddMenuListItem(
            data,
            this.menuID
        ).then(response => {
            this.menuListItems.push(this.newMenuItemModel(response.listItem));
            this.resetNewMenuItem();
            csrf.updateToken(response.csrfToken);
        });
    }

    async addMenuListItemLink() {
        const data = {
            menuitem: {
                ...ko.toJS(this.newMenuItem),
                type: 'link',
                menu_position: ko.toJS(this.menuListItems).length,
                language_id: this.currentLanguage().id
            },
            csrf_token: csrf.getToken()
        };

        MenuListItemsHandler.handleAddMenuListItem(
            data,
            this.menuID
        ).then(response => {
            this.menuListItems.push(this.newMenuItemModel(response.listItem));
            this.resetNewMenuItem();
            csrf.updateToken(response.csrfToken);

        });
    }

    updateMenuListItem = async item => {
        const data = {
            menuitem: {
                name: item.name(),
                page: item.page_id(),
                css_class: item.css_class(),
                link_to: item.link_to()
            },
            csrf_token: csrf.getToken(),
        };

        const response = await MenuListItemsHandler.handleUpdateMenuListItem(
            data,
            item.menu_id(),
            item.id()
        );
        if (response.message === 'success') {
            csrf.updateToken(response.csrfToken);
        }
    };

    deleteMenuListItem = async item => {
        const data = {
            csrf_token: csrf.getToken(),
        };

        const response = await MenuListItemsHandler.handleDeleteMenuListItem(
            data,
            item.menu_id(),
            item.id()
        );
        if (response.message === 'success') {
            this.menuListItems.remove(item);
            csrf.updateToken(response.csrfToken);
        }
    };

    setCurrentLanguage = (language) => {
        this.currentLanguage(language);
        this.filterMenuItems(language);
    }

    filterMenuItems = (language) => {
        const menuItems = this.menuListItems().filter(menuListItem => {
            const item = ko.toJS(menuListItem);
            return item.language_id === language.id;
        });
        this.filteredMenuItems(menuItems);
    }

    newMenuItemModel = (data) => {
        return new MenuItemViewModel({subListItems: [], ...data}, {
            deleteMenuListItem: this.deleteMenuListItem,
            updateMenuListItem: this.updateMenuListItem
        })
    }
}
