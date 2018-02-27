import ko from 'knockout';
import PagebuilderColumnModel from './PagebuilderColumnModel';

export default class PagebuilderColumnRowModel {
    constructor(data) {
        this.columns = ko.observableArray([]);
        data.columns.forEach(column => {
            this.columns.push(new PagebuilderColumnModel(column));
        });
    }
}