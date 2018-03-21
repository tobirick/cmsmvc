import ko from 'knockout';
import 'knockout-sortable';
import PagebuilderSectionModel from './PagebuilderSectionModel';
import PagebuilderColumnRowModel from './PagebuilderColumnRowModel';
import PagebuilderRowModel from './PagebuilderRowModel';
import PagebuilderElementModel from './PagebuilderElementModel';

import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderMainViewModel {
   constructor() {
      this.csrfToken = document.getElementById('csrftoken');
      this.csrfTokenVal = document.getElementById('csrftoken').value;
      this.html = ko.observable('');
      this.possibleColumns = ko.observableArray([]);
      this.pageID = document.getElementById('pageid').value;
      this.sections = ko.observableArray();
      this.elements = ko.observableArray([]);

      this.popupOpen = ko.observable(false);
      this.sectionSelected = ko.observable(false);
      this.rowSelected = ko.observable(false);
      this.elementSelected = ko.observable(false);

      this.fetchSections();
      this.setPossibleColumns();

      this.getPageBuilderElements();
      //this.addSection();
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

   openSettings = data => {
      this.popupOpen(true);
      if (data instanceof PagebuilderSectionModel) {
         this.sectionSelected(data);
      }
      if (data instanceof PagebuilderRowModel) {
         this.rowSelected(data);
      }
      if (data instanceof PagebuilderElementModel) {
         this.elementSelected(data);
      }
   };

   closeSettings = data => {
      this.popupOpen(false);
      this.sectionSelected(false);
      this.rowSelected(false);
      this.elementSelected(false);
   };

   async savetoDB() {
       this.generateHTML();
      const data = {
         csrf_token: this.csrfTokenVal,
         sections: ko.toJS(this.sections),
         page_id: this.pageID,
         html: ko.toJS(this.html)
      };

      console.log(data.sections);

      const response = await PagebuilderHandler.savePagebuilder(data);

      this.updateCSRF(response.csrfToken);
   }

   async fetchSections() {
      const response = await PagebuilderHandler.fetchSections(this.pageID);

      if (response) {
         response.forEach(section => {
            const paddingArr = section.padding.split(' ');
            const marginArr = section.margin.split(' ');  
            const paddingVM = {top: paddingArr[0], right: paddingArr[1], bottom: paddingArr[2], left: paddingArr[3]};
            const marginVM = {top: marginArr[0], right: marginArr[1], bottom: marginArr[2], left: marginArr[3]};
            this.sections.push(
               new PagebuilderSectionModel({...section, paddingVM, marginVM}, {
                  cloneSection: this.cloneSection,
                  deleteSection: this.deleteSection
               })
            );
         });
      }
   }

   setPossibleColumns() {
      this.possibleColumns([
         new PagebuilderColumnRowModel({}, ['12']),
         new PagebuilderColumnRowModel({}, ['9', '3']),
         new PagebuilderColumnRowModel({}, ['8', '4']),
         new PagebuilderColumnRowModel({}, ['6', '6']),
         new PagebuilderColumnRowModel({}, ['4', '4', '4']),
         new PagebuilderColumnRowModel({}, ['3', '3', '3', '3'])
      ]);
   }

   async getPageBuilderElements() {
      const data = {
         csrf_token: this.csrfTokenVal
      };

      const response = await PagebuilderHandler.loadPagebuilderElements(data);
      response.pagebuilderItems.forEach(dataItem => {
         this.elements.push(
            new PagebuilderElementModel({
               ...dataItem,
               id: '',
               item_id: dataItem.id
            })
         );
      });

      console.log(ko.toJS(this.elements));

      this.updateCSRF(response.csrfToken);
   }

   addSection() {
      this.sections.push(
         new PagebuilderSectionModel(
            {},
            {
               cloneSection: this.cloneSection,
               deleteSection: this.deleteSection
            }
         )
      );
   }

   cloneSection = section => {
      const index = this.sections.indexOf(section) + 1;
      this.sections.splice(
         index,
         0,
         new PagebuilderSectionModel(
            {
               ...ko.toJS(section),
               id: ''
            },
            {
               cloneSection: this.cloneSection,
               deleteSection: this.deleteSection
            }
         )
      );
   };

   deleteSection = section => {
      this.sections.remove(section);
   };

   generateHTML() {
      let html = '';
      this.sections().forEach(section => {
         html += section.html();
         section.rows().forEach(row => {
            html += row.html();
            row.columnrows().forEach(columnrow => {
               columnrow.columns().forEach(column => {
                html += `<div class="col-${column.col()}">${column.element() !== null ? column.element().generatedHTML() : ''}</div>`;
               });
            });
            html += `</div>`;
         });
         html += `</section>`;
      });
      this.html(html);

      console.log(ko.toJS(this.html));
   }
}
