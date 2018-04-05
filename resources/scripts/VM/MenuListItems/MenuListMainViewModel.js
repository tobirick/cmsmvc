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
         css_class: ''
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
            if (key !== 'menu_id') this.newMenuItem[key](null);
         }
      }
   }

   async updateMenuPositions() {
      console.log(ko.toJS(this.filteredMenuItems));
      this.filteredMenuItems().forEach((menuListItem, position) => {
         menuListItem.menu_position(position);
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
           this.menuListItems.push(this.newMenuItemModel(dataItem));
        });
      });
   }

   async addMenuListItem() {
      const data = {
         menuitem: {
            ...ko.toJS(this.newMenuItem),
            menu_position: ko.toJS(this.menuListItems).length,
            language_id: this.currentLanguage().id
         },
         csrf_token: csrf.getToken()
      };

      const response = await MenuListItemsHandler.handleAddMenuListItem(
         data,
         this.menuID
      );

      this.menuListItems.push(this.newMenuItemModel(response.listItem));
      this.resetNewMenuItem();

      csrf.updateToken(response.csrfToken);
   }

   updateMenuListItem = async item => {
      const data = {
         menuitem: {
            name: item.name(),
            page: item.page_id(),
            css_class: item.css_class()
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
    return menuListItem.language_id() === language.id;
  });
  this.filteredMenuItems(menuItems);
 }

 newMenuItemModel = (data) => {
  return new MenuItemViewModel(data, {
    deleteMenuListItem: this.deleteMenuListItem,
    updateMenuListItem: this.updateMenuListItem
 })
 }
}
