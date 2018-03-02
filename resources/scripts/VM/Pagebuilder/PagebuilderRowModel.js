import ko from 'knockout';
import PagebuilderColumnRowModel from './PagebuilderColumnRowModel';
import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderRowModel {
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

      this.columnrows = ko.observableArray([]);
      if (this.id) {
         this.fetchColumnRows();
      }

      this.deleteRow = delegates.deleteRow;
      this.cloneRow = delegates.cloneRow;
   }

   async fetchColumnRows() {
      const response = await PagebuilderHandler.fetchColumnRows(this.id());

      response.forEach(columnrow => {
         this.columnrows.push(
            new PagebuilderColumnRowModel({
               ...columnrow
            })
         );
      });
   }

   addColumnRow() {
      this.columnrows.push(new PagebuilderColumnRowModel({}));
   }
}
