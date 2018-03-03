import ko from 'knockout';
import PagebuilderColumnRowModel from './PagebuilderColumnRowModel';
import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderRowModel {
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

      this.columnrows = ko.observableArray([]);

      if (ko.toJS(this.id)) {
         this.fetchColumnRows();
      } else if (data.columnrows) {
         data.columnrows.forEach(columnrow => {
            this.columnrows.push(
               new PagebuilderColumnRowModel({ ...columnrow, id: '' })
            );
         });
      }

      this.deleteRow = delegates.deleteRow;
      this.cloneRow = delegates.cloneRow;
   }

   setStylesValue(data) {
      return data;
   }

   async fetchColumnRows() {
      const response = await PagebuilderHandler.fetchColumnRows(this.id());

      if (response) {
         response.forEach(columnrow => {
            this.columnrows.push(new PagebuilderColumnRowModel(columnrow));
         });
      }
   }

   addColumnRow() {
      this.columnrows.push(new PagebuilderColumnRowModel({}));
   }
}
