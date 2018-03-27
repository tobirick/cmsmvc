import ko from 'knockout';
import PageItemViewModel from '../Pages/PageItemViewModel';
import MenuItemViewModel from './MenuItemViewModel';
import PagesHandler from '../../Handlers/PagesHandler';
import MenuListItemsHandler from '../../Handlers/MenuListItemsHandler';

export default class MenuListMainViewModel {
   constructor() {
      this.menuID = document.getElementById('menuid').value;
      this.defaultData = {
         id: '',
         name: '',
         menu_id: this.menuID,
         page_id: 0,
         menu_position: 0
      };
      this.menuListItems = ko.observableArray([]);
      this.pagesList = ko.observableArray([]);
      this.csrfToken = document.getElementById('csrftoken');
      this.csrfTokenVal = document.getElementById('csrftoken').value;

      this.newMenuItem = new MenuItemViewModel(this.defaultData, {
         deleteMenuListItem: this.deleteMenuListItem,
         updateMenuListItem: this.updateMenuListItem
      });
   }

   resetNewMenuItem() {
      for (let key in this.newMenuItem) {
         if (ko.isObservable(this.newMenuItem[key])) {
            if (key !== 'menu_id') this.newMenuItem[key](null);
         }
      }
   }

   updateCSRF(newCsrfToken) {
      this.csrfTokenVal = newCsrfToken;
      this.csrfToken.value = newCsrfToken;
      const csrfTokenInputEls = document.querySelectorAll(
         'input[name="csrf_token"]'
      );
      csrfTokenInputEls.forEach(csrfTokenInputEl => {
         csrfTokenInputEl.value = newCsrfToken;
      });
   }

   async updateMenuPositions() {
      this.menuListItems().forEach((menuListItem, position) => {
         menuListItem.menu_position(position);
      });

      const data = {
         csrf_token: this.csrfTokenVal,
         menuitems: ko.toJS(this.menuListItems)
      };

      const response = await MenuListItemsHandler.handleUpdateMenuListItemPositions(
         data,
         this.menuID
      );

      this.updateCSRF(response.csrfToken);
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
           this.menuListItems.push(
              new MenuItemViewModel(dataItem, {
                 deleteMenuListItem: this.deleteMenuListItem,
                 updateMenuListItem: this.updateMenuListItem
              })
           );
        });
      });
   }

   async addMenuListItem() {
      const data = {
         menuitem: {
            ...ko.toJS(this.newMenuItem),
            menu_position: ko.toJS(this.menuListItems).length
         },
         csrf_token: this.csrfTokenVal
      };

      const response = await MenuListItemsHandler.handleAddMenuListItem(
         data,
         this.menuID
      );

      this.menuListItems.push(
         new MenuItemViewModel(response.listItem, {
            deleteMenuListItem: this.deleteMenuListItem,
            updateMenuListItem: this.updateMenuListItem
         })
      );
      this.resetNewMenuItem();

      this.updateCSRF(response.csrfToken);
   }

   updateMenuListItem = async item => {
      const data = {
         menuitem: {
            name: item.name(),
            page: item.page_id()
         },
         csrf_token: this.csrfTokenVal
      };

      const response = await MenuListItemsHandler.handleUpdateMenuListItem(
         data,
         item.menu_id(),
         item.id()
      );
      if (response.message === 'success') {
         this.updateCSRF(response.csrfToken);
      }
   };

   deleteMenuListItem = async item => {
      const data = {
         csrf_token: this.csrfTokenVal
      };

      const response = await MenuListItemsHandler.handleDeleteMenuListItem(
         data,
         item.menu_id(),
         item.id()
      );
      if (response.message === 'success') {
         this.menuListItems.remove(item);
         this.updateCSRF(response.csrfToken);
      }
   };
}
