import ko from 'knockout';
import PagebuilderElementModel from './PagebuilderElementModel';

export default class PagebuilderColumnModel {
    constructor(data, delegates) {
        this.id = ko.observable(data.id || '');
        this.col = ko.observable(data.col);

        this.element = ko.observable(null);
        this.elementSelected = ko.observable(false);

        if (ko.toJS(this.id)) {
            if (data.element) {
                const paddingArr = data.element.padding.split(' ');
                const marginArr = data.element.margin.split(' ');
                const paddingVM = { top: paddingArr[0], right: paddingArr[1], bottom: paddingArr[2], left: paddingArr[3] };
                const marginVM = { top: marginArr[0], right: marginArr[1], bottom: marginArr[2], left: marginArr[3] };
                this.element(this.newElement({ ...data.element, paddingVM, marginVM }));
                this.elementSelected(true);
            }
        } else if (data.element) {
            this.element(this.newElement({ ...ko.toJS(data.element), id: '' }));
            this.elementSelected(true);
        }

        this.removeCol = delegates.removeCol;

        this.deletedElements = [];
    }

    setElement = element => {
        if (!this.elementSelected()) {
            this.element(this.newElement({ ...ko.toJS(element), id: '' }));
            this.elementSelected(true);
        }
    };

    deleteElement = () => {
        this.deletedElements.push(this.element().id());
        this.elementSelected(false);
        this.element(null);
    };

    newElement = (data) => {
        return new PagebuilderElementModel(data);
    }
}
