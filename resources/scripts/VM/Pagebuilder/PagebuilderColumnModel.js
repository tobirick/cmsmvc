import ko from 'knockout';
import PagebuilderElementModel from './PagebuilderElementModel';

export default class PagebuilderColumnModel {
    constructor(data) {
        this.col = ko.observable(data);
        this.setDefaults();
        this.element = ko.observable(new PagebuilderElementModel(this.defaultElement));
    }

    setDefaults() {
        this.defaultElement = {
            html: 'heyo was geht'
        };
    }

    setElement = () => {
        console.log(ko.toJS(this));
        console.log('chose html element');
    }
}