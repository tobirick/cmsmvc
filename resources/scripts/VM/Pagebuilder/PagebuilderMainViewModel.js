import ko from 'knockout';
import 'knockout-sortable';
import PagebuilderSectionModel from './PagebuilderSectionModel';
import PagebuilderColumnRowModel from './PagebuilderColumnRowModel';

export default class PagebuilderMainViewModel {
    constructor() {
        this.html = ko.observable('');
        this.possibleColumns = [
            new PagebuilderColumnRowModel({columns: ['12']}),
            new PagebuilderColumnRowModel({columns: ['9', '3']}),
            new PagebuilderColumnRowModel({columns: ['8', '4']}),
            new PagebuilderColumnRowModel({columns: ['6', '6']}),
            new PagebuilderColumnRowModel({columns: ['4', '4', '4']}),
            new PagebuilderColumnRowModel({columns: ['3', '3', '3', '3']})
        ];
        this.setDefaults();

        this.sections = ko.observableArray([]);
        this.addSection();
    }

    setDefaults() {
        this.defaultSection = {
            rows: []
        };
    }

    addSection() {
        this.sections.push(new PagebuilderSectionModel(this.defaultSection, {
            deleteSection: this.deleteSection
        }))
        this.setDefaults();
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
                        html += `<div class="col-${column.col()}">${column.element().html()}</div>`;
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