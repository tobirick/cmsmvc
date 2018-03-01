import ko from 'knockout';
import 'knockout-sortable';
import PagebuilderSectionModel from './PagebuilderSectionModel';
import PagebuilderColumnRowModel from './PagebuilderColumnRowModel';
import PagebuilderElementModel from './PagebuilderElementModel';

import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderMainViewModel {
    constructor() {
        this.csrfToken = document.getElementById('csrftoken');
        this.csrfTokenVal = document.getElementById('csrftoken').value;
        this.html = ko.observable('');
        this.possibleColumns = ko.observableArray([]);
        this.pageID = 7;
        this.sections = ko.observableArray();
        this.elements = ko.observableArray([]);

        this.fetchSections();
        this.setPossibleColumns();

        this.getPageBuilderElements();
        //this.addSection();
    }

    updateCSRF(newCsrfToken) {
        this.csrfTokenVal = newCsrfToken;
        this.csrfToken.value = newCsrfToken;
    }

    async savetoDB() {
        const data = {
            csrf_token: this.csrfTokenVal,
            sections: ko.toJS(this.sections),
            page_id: this.pageID
        };

        console.log(data.sections);

        const response = await PagebuilderHandler.savePagebuilder(data);

        this.updateCSRF(response.csrfToken);
    }

    async fetchSections() {
        const response = await PagebuilderHandler.fetchSections(this.pageID);
        
        response.forEach((section) => {
            this.sections.push(new PagebuilderSectionModel({
                ...section
            },
            {
                cloneSection: this.cloneSection,
                deleteSection: this.deleteSection
            }));
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

        console.log(ko.toJS(this.possibleColumns));
    }

    async getPageBuilderElements() {
        const data = {
            csrf_token: this.csrfTokenVal
        };

        const response = await PagebuilderHandler.loadPagebuilderElements(data);
        response.pagebuilderItems.forEach((dataItem) => {
            this.elements.push(new PagebuilderElementModel(dataItem));
        });

        this.updateCSRF(response.csrfToken);
    }

    addSection() {
        this.sections.push(new PagebuilderSectionModel({},
        {
            cloneSection: this.cloneSection,
            deleteSection: this.deleteSection
        }));
    }

    cloneSection = (section) => {
        console.log('clone section');
    }

    deleteSection = (section) => {
        this.sections.remove(section);
    }

    generateHTML() {
        let html = '';
        this.sections().forEach(section => {
            html += `<section>`;
            section.rows().forEach(row => {
                html += `<div class="row">`;
                row.columnrows().forEach(columnrow => {
                    columnrow.columns().forEach(column => {
                        html += `<div class="col-${column.col()}">${column.element() !== null ? column.element().html() : ''}</div>`;
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