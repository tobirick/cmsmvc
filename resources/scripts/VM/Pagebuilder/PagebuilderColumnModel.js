import ko from 'knockout';
import PagebuilderElementModel from './PagebuilderElementModel';

export default class PagebuilderColumnModel {
    constructor(data) {
        this.col = ko.observable(data);
        this.element = ko.observable(null);
        this.elementSelected = ko.observable(false);
    }

    setElement = (element) => {
        if(!this.elementSelected() && element instanceof PagebuilderElementModel) {
            console.log(element);
            this.element(element);
            this.elementSelected(true);
        }
    }

    openSettings() {
        console.log('open settings for column');
    }

    deleteElement = () => {
        this.element(null);
        this.elementSelected(false);
    }
}