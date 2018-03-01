import ko from 'knockout';
import PagebuilderColumnRowModel from './PagebuilderColumnRowModel';
import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderRowModel {
    constructor(data, delegates) {
        for(let key in data) {
            this[key] = ko.observable(data[key]);
        }
        this.columnrows = ko.observableArray([]);
        if(this.id) {
         this.fetchColumnRows();
        }

        this.deleteRow = delegates.deleteRow;
        this.cloneRow = delegates.cloneRow;
    }

    async fetchColumnRows() {
        const response = await PagebuilderHandler.fetchColumnRows(this.id());
        
        response.forEach((columnrow) => {
            this.columnrows.push(new PagebuilderColumnRowModel({
                ...columnrow
            }));
        });
    }

    openSettings() {
        console.log('open settings for row');
    }

    addColumnRow() {
        this.columnrows.push(new PagebuilderColumnRowModel({}));
    }
}