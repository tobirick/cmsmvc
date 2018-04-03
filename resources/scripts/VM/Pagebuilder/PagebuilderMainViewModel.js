import ko from 'knockout';
import csrf from '../../csrf';

import PagebuilderSectionModel from './PagebuilderSectionModel';
import PagebuilderColumnRowModel from './PagebuilderColumnRowModel';
import PagebuilderRowModel from './PagebuilderRowModel';
import PagebuilderElementModel from './PagebuilderElementModel';

import PagebuilderHandler from '../../Handlers/PagebuilderHandler';
import LanguagesHandler from '../../Handlers/LanguagesHandler';
import PagesHandler from '../../Handlers/PagesHandler';

export default class PagebuilderMainViewModel {
   constructor() {
      this.possibleColumns = ko.observableArray([]);
      this.pageID = document.getElementById('pageid').value;
      this.pageContentID = 1;
      this.sections = ko.observableArray();
      this.elements = ko.observableArray([]);

      this.langPages = ko.observableArray([]);
      this.defaultPageSettings = ko.observable();
      this.page = ko.observable();

      this.popupOpen = ko.observable(false);
      this.sectionSelected = ko.observable(false);
      this.rowSelected = ko.observable(false);
      this.elementSelected = ko.observable(false);

      this.languages = ko.observableArray([]);
      this.currentLanguage = ko.observable(null);

      this.setPossibleColumns();
      //this.addSection();

      this.alert = ko.observable({
        visible: ko.observable(false),
        text: ko.observable(),
        type: ko.observable()
    });
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

    setCurrentLanguage = (language) => {
       this.currentLanguage(language);

       const page = this.langPages().find(langPage => {
        return langPage.language_id() === language.id;
       });

       this.page(page);
    }

    fetchPage() {
      const data = {
        csrf_token: csrf.getToken(),
        pageID: this.pageID
      };

      return PagesHandler.fetchPage(data).then((response) => {
        csrf.updateToken(response.csrfToken);

        let defaultPage = {};
        for(let key in response.defaultPage) {
          defaultPage[key] = ko.observable(response.defaultPage[key]);
       }

       const isActive = parseInt(defaultPage.is_active());
       defaultPage.is_active(isActive);

       this.defaultPageSettings(defaultPage);

        response.langs.forEach(langPage => {
          let page = {};
          for(let key in langPage) {
             page[key] = ko.observable(langPage[key]);
          }

          this.langPages.push(page);      
        });

        this.page(this.langPages()[0]);
        console.log(ko.toJS(this.langPages));
      });
    }

    fetchLanguages() {
      const data = {
        csrf_token: csrf.getToken(),
      };

      return LanguagesHandler.fetchLanguages(data).then((response) => {
        csrf.updateToken(response.csrfToken);
         response.languages.forEach(language => {
            this.languages.push(language);
         });
         this.currentLanguage(this.languages()[0]);
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
      const spContainerEls = document.querySelectorAll('.sp-container');
      spContainerEls.forEach(spContainerEl => {
         spContainerEl.parentNode.removeChild(spContainerEl);
      });
   };

   async savetoDB() {
      const data = {
        csrf_token: csrf.getToken(),
         sections: ko.toJS(this.sections),
         page_id: this.pageID,
         languages: [],
         defaultPage: ko.toJS(this.defaultPageSettings)
      };

      this.languages().forEach(language => {
         const sections = ko.toJS(this.sections).filter(section => {
            return section.language_id === language.id;
         });

         const page = ko.toJS(this.langPages).find(page => {
            return language.id === page.language_id;
         });

         data.languages.push({
            language_id: language.id,
            html: this.generateHTML(sections),
            page: page
         })
      })

      const response = await PagebuilderHandler.savePagebuilder(data);

      if(response) {
        csrf.updateToken(response.csrfToken);
          this.showAlert('success', 'Page successfully saved!');
      }
   }

   fetchSections() {
      const data = {
        csrf_token: csrf.getToken(),
         pageID: this.pageID
      };

      this.sections([]);

      return PagebuilderHandler.fetchSections(data).then(response => {
        csrf.updateToken(response.csrfToken);
          if (response.sections.length > 0) {
             response.sections.forEach(section => {
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
          } else {
            this.sections.push(
                new PagebuilderSectionModel({
                   language_id: this.currentLanguage().id
                }, {
                   cloneSection: this.cloneSection,
                   deleteSection: this.deleteSection
                })
             );
          }
      });
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
        csrf_token: csrf.getToken(),
      };

      return PagebuilderHandler.loadPagebuilderElements(data).then((response) => {
        csrf.updateToken(response.csrfToken);
         response.pagebuilderItems.forEach(dataItem => {
            this.elements.push(
               new PagebuilderElementModel({
                  ...dataItem,
                  id: '',
                  item_id: dataItem.id
               })
            );
         });
      });
   }

   addSection() {
      this.sections.push(
         new PagebuilderSectionModel(
            {
               language_id: this.currentLanguage().id
            },
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

   generateHTML(sections) {
      let html = '';
      sections.forEach(section => {
         html += section.html;
         section.rows.forEach(row => {
            html += row.html;
            row.columnrows.forEach(columnrow => {
               columnrow.columns.forEach(column => {
                html += `<div class="col-${column.col}">${column.element !== null ? column.element.generatedHTML : ''}</div>`;
               });
            });
            html += `</div>`;
         });
         html += `</div></section>`;
      });
      return html;
   }
}
