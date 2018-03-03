import ko from 'knockout';
import PagebuilderRowModel from './PagebuilderRowModel';
import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderSectionModel {
   constructor(data, delegates) {
      this.id = ko.observable(data.id || '');
      this.name = ko.observable(data.name || '');
      this.position = ko.observable(data.position || '');
      this.css_class = ko.observable(data.css_class || '');
      this.css_id = ko.observable(data.css_id || '');
      this.styles = ko.observable(data.css_name || '');

      this.padding = ko.observable({
         top: 0,
         right: 0,
         bottom: 0,
         left: 0
      });
      this.margin = ko.observable({
         top: 0,
         right: 0,
         bottom: 0,
         left: 0
      });
      this.bgColor = ko.observable();

      this.rows = ko.observableArray([]);

      if (ko.toJS(this.id)) {
         this.fetchRows();
      } else if (data.rows) {
         data.rows.forEach(row => {
            this.rows.push(
               new PagebuilderRowModel(
                  {
                     ...row,
                     id: ''
                  },
                  {
                     deleteRow: this.deleteRow,
                     cloneRow: this.cloneRow
                  }
               )
            );
         });
      }

      this.deleteSection = delegates.deleteSection;
      this.cloneSection = delegates.cloneSection;
   }

   async fetchRows() {
      const response = await PagebuilderHandler.fetchRows(this.id());

      response.forEach(row => {
         this.rows.push(
            new PagebuilderRowModel(row, {
               deleteRow: this.deleteRow,
               cloneRow: this.cloneRow
            })
         );
      });
   }

   deleteRow = row => {
      this.rows.remove(row);
   };

   cloneRow = row => {
      const index = this.rows.indexOf(row) + 1;
      this.rows.splice(
         index,
         0,
         new PagebuilderRowModel(
            {
               ...ko.toJS(row),
               id: ''
            },
            {
               deleteRow: this.deleteRow,
               cloneRow: this.cloneRow
            }
         )
      );
   };

   addRow() {
      this.rows.push(
         new PagebuilderRowModel(
            {},
            {
               deleteRow: this.deleteRow,
               cloneRow: this.cloneRow
            }
         )
      );
   }
}
