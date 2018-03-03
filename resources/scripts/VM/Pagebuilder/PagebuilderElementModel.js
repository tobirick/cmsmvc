import ko from 'knockout';

export default class PagebuilderElementModel {
    constructor(data) {
        for(let key in data) {
            this[key] = ko.observable(data[key]);
        }

        this.html = ko.observable(null);
    }

    updateHTML = (data) => {

    }
}