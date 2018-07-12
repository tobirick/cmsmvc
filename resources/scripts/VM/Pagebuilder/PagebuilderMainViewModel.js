import ko from 'knockout';
import csrf from '../../csrf';
import helpers from '../../helpers';

import PagebuilderSectionModel from './PagebuilderSectionModel';
import PagebuilderColumnRowModel from './PagebuilderColumnRowModel';
import PagebuilderRowModel from './PagebuilderRowModel';
import PagebuilderElementModel from './PagebuilderElementModel';
import MediaPopupMainViewModel from '../MediaPopup/MediaPopupMainViewModel';

import PagebuilderHandler from '../../Handlers/PagebuilderHandler';
import LanguagesHandler from '../../Handlers/LanguagesHandler';
import PagesHandler from '../../Handlers/PagesHandler';

export default class PagebuilderMainViewModel {
    constructor() {
        this.mediaPopupVM = ko.observable(new MediaPopupMainViewModel());

        this.possibleColumns = ko.observableArray([]);
        this.pageID = document.getElementById('pageid').value;
        this.defaultLanguageID = document.getElementById('defaultlanguageid').value;
        this.pageContentID = 1;
        this.sections = ko.observableArray([]);
        this.filteredSections = ko.observableArray([]);
        this.elements = ko.observableArray([]);
        this.elementsFilterQuery = ko.observable('');

        this.filteredElements = ko.computed(() => {
            const search = this.elementsFilterQuery().toLowerCase();
            const filtered = this.elements().filter(element => {
                return element.item_name().toLowerCase().indexOf(search) >= 0;
            });
            return filtered;
        })

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

        this.sections.subscribe(() => {
            this.filterSections(this.currentLanguage());
        });

        this.currentPageURL = ko.computed(() => {
            if (this.currentLanguage()) {
                return `${window.location.origin}/${this.currentLanguage().id === this.defaultLanguageID ? '' : this.currentLanguage().iso + '/'}${this.defaultPageSettings().slug()}`;
            }
        });

        this.alert = ko.observable({
            visible: ko.observable(false),
            text: ko.observable(),
            type: ko.observable()
        });

        this.deletedSections = [];
    }

    setInEditInActive = () => {
        const data = {
            csrf_token: csrf.getToken(),
            pageID: this.pageID
        };

        const response = PagesHandler.setInEditInActive(data);
        
        csrf.updateToken(response.csrfToken);
    }

    openMediaPopup = (element) => {
        this.mediaPopupVM().openMediaPopup();
        this.mediaPopupVM().setInitialMediaElement(element instanceof PagebuilderSectionModel || element instanceof PagebuilderRowModel ? element.bg_image() : element.value());
        const subscription = this.mediaPopupVM().selectedMediaElement.subscribe(() => {
            const path = this.mediaPopupVM().selectedMediaElementPath();
            if (path) {
                if (element instanceof PagebuilderSectionModel || element instanceof PagebuilderRowModel) {
                    element.bg_image(path);
                } else {
                    element.value(path);
                }
            }
        });

        this.mediaPopupVM().mediaPopupOpen.subscribe(() => {
            if(!this.mediaPopupVM().mediaPopupOpen()) {
                subscription.dispose();
            }
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

    fetchPage() {
        const data = {
            csrf_token: csrf.getToken(),
            pageID: this.pageID
        };

        return PagesHandler.fetchPage(data).then((response) => {
            csrf.updateToken(response.csrfToken);

            let defaultPage = {};
            for (let key in response.defaultPage) {
                defaultPage[key] = ko.observable(response.defaultPage[key]);
            }

            const isActive = parseInt(defaultPage.is_active());
            const inEdit = parseInt(defaultPage.in_edit());
            const whiteLogoActive = parseInt(defaultPage.white_logo_active());
            defaultPage.is_active(isActive);
            defaultPage.in_edit(inEdit);
            defaultPage.white_logo_active(whiteLogoActive);

            this.defaultPageSettings(defaultPage);

            this.defaultPageSettings().slug.subscribe(newValue => {
                this.defaultPageSettings().slug(helpers.createSlug(newValue));
            });

            response.langs.forEach(langPage => {
                let page = {};
                for (let key in langPage) {
                    page[key] = ko.observable(langPage[key]);
                }

                this.langPages.push(page);
            });

            this.page(this.langPages()[0]);
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
                    const paddingVM = { top: paddingArr[0], right: paddingArr[1], bottom: paddingArr[2], left: paddingArr[3] };
                    const marginVM = { top: marginArr[0], right: marginArr[1], bottom: marginArr[2], left: marginArr[3] };
                    this.sections.push(this.newSection({ ...section, paddingVM, marginVM }));
                });
            } else {
                this.sections.push(this.newSection({ language_id: this.currentLanguage().id }));
            }
            this.filterSections(this.currentLanguage());
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

    async savetoDB() {
        const data = {
            csrf_token: csrf.getToken(),
            sections: ko.toJS(this.sections),
            deletedSections: this.deletedSections,
            page_id: this.pageID,
            languages: [],
            defaultPage: ko.toJS(this.defaultPageSettings)
        };

        console.log(data.sections);

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

        if (response) {
            csrf.updateToken(response.csrfToken);
            this.showAlert('success', 'Page successfully saved!');
        }
    }

    copyFromLanguage = (language) => {
        const sections = this.sections().filter(section => {
            return section.language_id() === language.id
        });

        sections.forEach(section => {
            const newSection = this.newSection({ ...ko.toJS(section), id: '' });

            newSection.language_id(this.currentLanguage().id);
            this.sections.push(newSection);
        });

    }

    filterSections = (language) => {
        const sections = this.sections().filter(section => {
            return section.language_id() === language.id;
        });
        this.filteredSections(sections);
    }

    setCurrentLanguage = (language) => {
        this.currentLanguage(language);
        this.filterSections(language);

        const page = this.langPages().find(langPage => {
            return langPage.language_id() === language.id;
        });

        this.page(page);
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

    addSection() {
        this.sections.push(this.newSection({ language_id: this.currentLanguage().id }));
    }

    cloneSection = section => {
        const index = this.sections.indexOf(section) + 1;
        this.sections.splice(
            index,
            0,
            this.newSection({ ...ko.toJS(section), id: '' })
        );
    };

    deleteSection = section => {
        this.deletedSections.push(section.id());
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
                        html += `<div class="col-12 col-md-${column.col} ${column.element !== null ? column.element.css_class : '' }" ${column.element !== null && column.element.css_id !== '' ? `id="${column.element.css_id}"` : ''}>${column.element !== null ? column.element.generatedHTML : ''}</div>`;
                    });
                });
                html += `</div>`;
            });
            html += `</div></section>`;
        });
        return html;
    }

    newSection(data) {
        return new PagebuilderSectionModel(data,
            {
                cloneSection: this.cloneSection,
                deleteSection: this.deleteSection
            }
        )
    }
}
