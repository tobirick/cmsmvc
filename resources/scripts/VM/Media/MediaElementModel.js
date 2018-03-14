import ko from 'knockout';

export default class MediaElementModel {
    constructor(data, delegates) {
        for(let key in data) {
            this[key] = ko.observable(data[key]);
        }
    }

    changeFolder() {
        console.log('change folder');
    }
}