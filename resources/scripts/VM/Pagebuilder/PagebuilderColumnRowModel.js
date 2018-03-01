import ko from 'knockout';
import PagebuilderColumnModel from './PagebuilderColumnModel';
import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderColumnRowModel {
    constructor(data, defaultColumns = {}) {
        for(let key in data) {
            this[key] = ko.observable(data[key]);
        }

        this.columns = ko.observableArray([]);
        if(this.id) {
            this.fetchColumns();
        } else {
            defaultColumns.forEach(column => {
                this.columns.push(new PagebuilderColumnModel({col: column}));
            });
        }
    }

    async fetchColumns() {
        const response = await PagebuilderHandler.fetchColumns(this.id());
        
        response.forEach((column) => {
            this.addColumn(column);
        });
    }

    addColumn(column = {}) {
        this.columns.push(new PagebuilderColumnModel({
            ...column
        }));
    }
}