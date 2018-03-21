import ko from 'knockout';

export default class MediaElementModel {
    constructor(data, delegates) {
        for(let key in data) {
            this[key] = ko.observable(data[key]);
        }

        this.deleteMediaElement = delegates.deleteMediaElement;
        this.openFolder = delegates.openFolder;    
        this.openFile = delegates.openFile;
        this.changeFolder = delegates.changeFolder.bind(this);
    }
}