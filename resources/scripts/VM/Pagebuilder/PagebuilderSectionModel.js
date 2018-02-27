import ko from 'knockout';
import PagebuilderRowModel from './PagebuilderRowModel';

export default class PagebuilderSectionModel {
    constructor(data, delegates) {
        this.rows = ko.observableArray(data.rows);
        this.setDefaults();
        this.addRow();
        
        this.deleteSection = delegates.deleteSection;
    }

    setDefaults() {
        this.defaultRow = {
            columnrows: []
        };
    }

    deleteRow = (row) => {
        this.rows.remove(row);
    }

    addRow() {
        this.rows.push(new PagebuilderRowModel(this.defaultRow, {
            deleteRow: this.deleteRow
        }));
        this.setDefaults();
    }
}