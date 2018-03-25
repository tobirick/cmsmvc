import ko from 'knockout';
import MediaPopupMainViewModel from '../MediaPopup/MediaPopupMainViewModel';
import ThemeHandler from '../../Handlers/ThemeHandler';
import csrf from '../../csrf';
import helpers from '../../helpers';

export default class ThemeMainViewModel {
   constructor() {
      this.themeID = document.getElementById('themeid').value;

      this.headerStyles = ko.observableArray(['nav-right', 'nav-center', 'nav-left']);
      this.maxFooterColumns = 4;

      this.id = ko.observable('');
      this.name = ko.observable('');
      this.path = ko.observable('');
      this.logo = ko.observable('');
      this.favicon = ko.observable('');
      this.fixed_navigation = ko.observable(Number(0));
      this.google_analytics = ko.observable('');
      this.to_top = ko.observable(Number(0));
      this.header_code = ko.observable('');
      this.body_code = ko.observable('');
      this.header_layout = ko.observable('');
      this.footer_layout = ko.observable('');
      this.google_font = ko.observable('');
      this.custom_scripts = ko.observable('');
      this.custom_styles = ko.observable('');
      this.css = ko.observable('');

      this.footerColumns = ko.observableArray([]);
      
      this.fetchThemeSettings();

      this.mediaPopupVM = ko.observable(new MediaPopupMainViewModel());

      this.alert = ko.observable({
         visible: ko.observable(false),
         text: ko.observable(),
         type: ko.observable()
     });
   }

   setFooterColumns() {
      if(helpers.isJsonString(this.footer_layout())) {
         JSON.parse(this.footer_layout()).columns.forEach(column => {
            this.footerColumns.push({
               html: ko.observable(column.html),
               title: ko.observable(column.title)
            })
         });
      } else {
         this.footerColumns([
            {
               html: ko.observable(''),
               title: ko.observable('')
            },
            {
               html: ko.observable(''),
               title: ko.observable('')
            },
            {
               html: ko.observable(''),
               title: ko.observable('')
            },
            {
               html: ko.observable(''),
               title: ko.observable('')
            },
         ]);
      }
   }

   addFooterCol = () => {
      let cols = this.footerColumns();
      if(cols.length < this.maxFooterColumns) {
         this.footerColumns.push({
            html: ko.observable(''),
            title: ko.observable('')
         });
      }
   }

   removeFooterCol = () => {
      let cols = this.footerColumns();
      if(cols.length > 1) {
         this.footerColumns(cols.slice(0, cols.length - 1));
      }
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

   fetchThemeSettings() {
      const data = {
         themeID: this.themeID,
         csrf_token: csrf.getToken(),
      }

      ThemeHandler.fetchThemeSettings(data).then(response => {
         for(let key in response.theme) {
            this[key](response.theme[key]);
         }
         csrf.updateToken(response.csrfToken);
      }).then(() => {
         this.setFooterColumns();
      });
   }

   async save() {
      const data = {
         themeID: this.themeID,
         csrf_token: csrf.getToken(),
         theme: ko.toJS(this)
      }

      data.theme.footer_layout = this.generateFooterLayout();

      const response = await ThemeHandler.updateThemeSettings(data);
      if(response) {
         this.showAlert('success', 'Theme successfully updated!');
         csrf.updateToken(response.csrfToken);
      }
   }

   generateFooterLayout() {
      let footerLayout = {
         columns: []
      };
      this.footerColumns().forEach(footerColumn => {
         footerLayout.columns.push(ko.toJS(footerColumn));
      });

      return JSON.stringify(footerLayout);
   }

   openMediaPopup = (element) => {
      this.mediaPopupVM().openMediaPopup();
      const subscription = this.mediaPopupVM().selectedMediaElement.subscribe(() => {
         const path = this.mediaPopupVM().selectedMediaElementPath();
         if(path) {
             element(path);
         } else {
            subscription.dispose();
         }
     });
  }
}