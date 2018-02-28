import ko from 'knockout';
import 'knockout-sortable';
import PagebuilderSectionModel from './PagebuilderSectionModel';
import PagebuilderColumnRowModel from './PagebuilderColumnRowModel';
import PagebuilderElementModel from './PagebuilderElementModel';

import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderMainViewModel {
    constructor() {
        this.html = ko.observable('');
        this.possibleColumns = ko.observableArray([]);
        this.setPossibleColumns();
        this.setDefaults();

        this.getPageBuilderElements();
        this.sections = ko.observableArray([]);
        this.elements = ko.observableArray([]);
        this.addSection();
    }

    setPossibleColumns() {
        this.possibleColumns([
            new PagebuilderColumnRowModel({columns: ['12']}),
            new PagebuilderColumnRowModel({columns: ['9', '3']}),
            new PagebuilderColumnRowModel({columns: ['8', '4']}),
            new PagebuilderColumnRowModel({columns: ['6', '6']}),
            new PagebuilderColumnRowModel({columns: ['4', '4', '4']}),
            new PagebuilderColumnRowModel({columns: ['3', '3', '3', '3']})
        ]);
    }

    async getPageBuilderElements() {
        const data = await PagebuilderHandler.loadPagebuilderElements();
        data.forEach((dataItem) => {
            this.elements.push(new PagebuilderElementModel(dataItem));
        });
    }

    setDefaults() {
        this.defaultSection = {
            rows: []
        };
    }

    addSection() {
        this.sections.push(new PagebuilderSectionModel(this.defaultSection, {
            cloneSection: this.cloneSection,
            deleteSection: this.deleteSection
        }))
        this.setDefaults();
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