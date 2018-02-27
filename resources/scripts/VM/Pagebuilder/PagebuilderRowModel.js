import ko from 'knockout';
import PagebuilderColumnRowModel from './PagebuilderColumnRowModel';

export default class PagebuilderRowModel {
    constructor(data, delegates) {
        this.columnrows = ko.observableArray(data.columnrow);
        this.setDefaults();
        this.addElement();

        this.deleteRow = delegates.deleteRow;
    }

    setDefaults() {
        this.defaultColumnRow = {
            columns: ['12']
        };
    }

    addElement() {
        this.columnrows.push(new PagebuilderColumnRowModel(this.defaultColumnRow));
        this.setDefaults();
    }
}