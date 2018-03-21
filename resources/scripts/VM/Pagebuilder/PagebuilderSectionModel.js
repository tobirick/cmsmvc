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
      this.styles = ko.observable(data.styles || '');
      this.bg_color = ko.observable(data.bg_color || '');

      this.paddingVM = ko.observable(data.paddingVM ? {
        top: ko.observable(data.paddingVM.top || ''),
        right: ko.observable(data.paddingVM.right || ''),
        bottom: ko.observable(data.paddingVM.bottom || ''),
        left: ko.observable(data.paddingVM.left || '')
    } : {
      top: ko.observable(''),
      right: ko.observable(''),
      bottom: ko.observable(''),
      left: ko.observable('')
    });
    
    this.marginVM = ko.observable(data.marginVM ? {
        top: ko.observable(data.marginVM.top || ''),
        right: ko.observable(data.marginVM.right || ''),
        bottom: ko.observable(data.marginVM.bottom || ''),
        left: ko.observable(data.marginVM.left || '')
    } : {
      top: ko.observable(''),
      right: ko.observable(''),
      bottom: ko.observable(''),
      left: ko.observable('')
    });

      this.padding = ko.computed(() => {
          return `${this.paddingVM().top()} ${this.paddingVM().right()} ${this.paddingVM().bottom()} ${this.paddingVM().left()}`;
      })

      this.margin = ko.computed(() => {
        return `${this.marginVM().top()} ${this.marginVM().right()} ${this.marginVM().bottom()} ${this.marginVM().left()}`;
        })

        this.html = ko.computed(() => {
            return `<section class="${this.css_class()}" id="${this.css_id()}" styles="${this.styles()} background-color:${this.bg_color()};
                    padding-top:${this.paddingVM().top()}; padding-right:${this.paddingVM().right()}; padding-bottom:${this.paddingVM().bottom()}; padding-left:${this.paddingVM().left()};
                    margin-top:${this.marginVM().top()}; margin-right:${this.marginVM().right()}; margin-bottom:${this.marginVM().bottom()}; margin-left:${this.marginVM().left()};">
                    `;
        });

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

      if (response) {
         response.forEach(row => {
            const paddingArr = row.padding.split(' ');
            const marginArr = row.margin.split(' ');  
            const paddingVM = {top: paddingArr[0], right: paddingArr[1], bottom: paddingArr[2], left: paddingArr[3]};
            const marginVM = {top: marginArr[0], right: marginArr[1], bottom: marginArr[2], left: marginArr[3]};
            this.rows.push(
               new PagebuilderRowModel({...row, paddingVM, marginVM}, {
                  deleteRow: this.deleteRow,
                  cloneRow: this.cloneRow
               })
            );
         });
      }
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
