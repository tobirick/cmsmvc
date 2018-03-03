import ko from 'knockout';
import PagebuilderColumnModel from './PagebuilderColumnModel';
import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderColumnRowModel {
   constructor(data, defaultColumns = {}) {
      this.id = ko.observable(data.id || '');
      this.position = ko.observable(data.position || '');

      this.columns = ko.observableArray([]);
      if (ko.toJS(this.id)) {
         this.fetchColumns();
      } else if (Object.keys(defaultColumns).length > 0) {
         defaultColumns.forEach(column => {
            this.columns.push(new PagebuilderColumnModel({ col: column }));
         });
      } else if (data.columns) {
         data.columns.forEach(column => {
            this.columns.push(
               new PagebuilderColumnModel({ ...column, id: '' })
            );
         });
      }
   }

   async fetchColumns() {
      const response = await PagebuilderHandler.fetchColumns(this.id());

      response.forEach(column => {
         this.addColumn(column);
      });
   }

   addColumn(column = {}) {
      this.columns.push(
         new PagebuilderColumnModel({
            ...column
         })
      );
   }
}
