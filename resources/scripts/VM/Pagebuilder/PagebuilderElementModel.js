import ko from 'knockout';

export default class PagebuilderElementModel {
    constructor(data) {
        this.html = ko.observable(data.html);
    }

    updateHTML = (data) => {

    }
}