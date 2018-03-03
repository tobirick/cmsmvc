import ko from 'knockout';
import PagebuilderElementModel from './PagebuilderElementModel';
import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class PagebuilderColumnModel {
    constructor(data) {
        this.col = ko.observable(data.col);
        
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

    deleteElement = () => {
        this.element(null);
        this.elementSelected(false);
    }
}