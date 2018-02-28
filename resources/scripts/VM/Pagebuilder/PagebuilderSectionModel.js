import ko from 'knockout';
import PagebuilderRowModel from './PagebuilderRowModel';

export default class PagebuilderSectionModel {
    constructor(data, delegates) {
        this.rows = ko.observableArray(data.rows);
        this.setDefaults();
        this.addRow();
        
        this.deleteSection = delegates.deleteSection;
        this.cloneSection = delegates.cloneSection;
    }

    setDefaults() {
        this.defaultRow = {
            columnrows: []
        };
    }

    deleteRow = (row) => {
        this.rows.remove(row);
    }

    cloneRow = (row) => {
        console.log('clone row');
    }

    openSettings() {
        console.log('open settings for section');
    }

    addRow() {
        this.rows.push(new PagebuilderRowModel(this.defaultRow, {
            deleteRow: this.deleteRow,
            cloneRow: this.cloneRow
        }));
        this.setDefaults();
    }
}