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
        return `<div class="row ${this.css_class()}" id="${this.css_id()}" style="${this.styles()} background-color:${this.bg_color()};
                padding-top:${this.paddingVM().top()}; padding-right:${this.paddingVM().right()}; padding-bottom:${this.paddingVM().bottom()}; padding-left:${this.paddingVM().left()};
                margin-top:${this.marginVM().top()}; margin-right:${this.marginVM().right()}; margin-bottom:${this.marginVM().bottom()}; margin-left:${this.marginVM().left()};">
                `;
    });

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
