import ko from 'knockout';
import PagebuilderColumnModel from './PagebuilderColumnModel';

export default class PagebuilderColumnRowModel {
    constructor(data, defaultColumns = {}) {
        this.id = ko.observable(data.id || '');
        this.position = ko.observable(data.position || '');

        this.columns = ko.observableArray([]);
        if (ko.toJS(this.id)) {
            data.columns.forEach(column => {
                this.columns.push(this.newColumn(column));
            });
        } else if (Object.keys(defaultColumns).length > 0) {
            defaultColumns.forEach(column => {
                this.columns.push(this.newColumn({ col: column }));
            });
        } else if (data.columns) {
            data.columns.forEach(column => {
                this.columns.push(this.newColumn({ ...column, id: '' }));
            });
        }

        this.deletedColumns = [];
    }

    addColumn(column = {}) {
        this.columns.push(this.newColumn({ ...column }));
    }

    removeCol = (col) => {
        this.deletedColumns.push(col.id());
        this.columns.remove(col);
    }

    newColumn = (data) => {
        return new PagebuilderColumnModel(data, {
            removeCol: this.removeCol
        });
    };
}
