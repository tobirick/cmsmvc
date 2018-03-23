import ko from 'knockout';
import PagebuilderRowModel from './PagebuilderRowModel';
import PagebuilderHandler from '../../Handlers/PagebuilderHandler';
import MediaPopupMainViewModel from '../MediaPopup/MediaPopupMainViewModel';

export default class PagebuilderSectionModel {
   constructor(data, delegates) {
      this.mediaPopupVM = ko.observable(new MediaPopupMainViewModel());

      this.id = ko.observable(data.id || '');
      this.name = ko.observable(data.name || '');
      this.position = ko.observable(data.position || '');
      this.css_class = ko.observable(data.css_class || '');
      this.css_id = ko.observable(data.css_id || '');
      this.styles = ko.observable(data.styles || '');
      this.bg_color = ko.observable(data.bg_color || '');
      this.bg_image = ko.observable(data.bg_image || '');

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
            return `<section 
                    ${this.css_class() !== '' ? `class="${this.css_class()}"` :''}
                    ${this.css_id() !== '' ? `id="${this.css_id()}"` :''} 
                    style="${this.styles()}
                    ${this.bg_color() !== '' ? `background-color:${this.bg_color()};` : ''}
                    ${this.paddingVM().top() !== '' ? `padding-top:${this.paddingVM().top()};` : ''}
                    ${this.paddingVM().right() !== '' ? `padding-right:${this.paddingVM().right()};` : ''}
                    ${this.paddingVM().bottom() !== '' ? `padding-bottom:${this.paddingVM().bottom()};` : ''}
                    ${this.paddingVM().left() !== '' ? `padding-left:${this.paddingVM().left()};` : ''}
                    ${this.marginVM().top() !== '' ? `margin-top:${this.marginVM().top()};` : ''}
                    ${this.marginVM().right() !== '' ? `margin-right:${this.marginVM().right()};` : ''}
                    ${this.marginVM().bottom() !== '' ? `margin-bottom:${this.marginVM().bottom()};` : ''}
                    ${this.marginVM().left() !== '' ? `margin-left:${this.marginVM().left()};` : ''}
                    ">`;
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
      } else {
        this.rows.push(
          new PagebuilderRowModel({}, {
             deleteRow: this.deleteRow,
             cloneRow: this.cloneRow
          })
       );
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

   openMediaPopup = () => {
      this.mediaPopupVM().openMediaPopup();
      this.mediaPopupVM().selectedMediaElement.subscribe(() => {
          const path = this.mediaPopupVM().selectedMediaElementPath();
          if(path) {
              this.bg_image(path);
          }
      });
  }
}