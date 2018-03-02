import ko from 'knockout';
import PagebuilderRowModel from './PagebuilderRowModel';
import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderSectionModel {
   constructor(data, delegates) {
      for (let key in data) {
         this[key] = ko.observable(data[key]);
      }

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

      if (this.id) {
         this.fetchRows();
      }

      this.deleteSection = delegates.deleteSection;
      this.cloneSection = delegates.cloneSection;
   }

   async fetchRows() {
      const response = await PagebuilderHandler.fetchRows(this.id());

      response.forEach(row => {
         this.rows.push(
            new PagebuilderRowModel(
               {
                  ...row
               },
               {
                  deleteRow: this.deleteRow,
                  cloneRow: this.cloneRow
               }
            )
         );
      });
   }

   deleteRow = row => {
      this.rows.remove(row);
   };

   cloneRow = row => {
      console.log('clone row');
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
