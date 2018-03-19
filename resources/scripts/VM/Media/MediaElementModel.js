import ko from 'knockout';
import MediaHandler from '../../Handlers/MediaHandler';
import csrf from '../../csrf';

export default class MediaElementModel {
    constructor(data, delegates) {
        for(let key in data) {
            this[key] = ko.observable(data[key]);
        }

        this.deleteMediaElement = delegates.deleteMediaElement;
        this.openFolder = delegates.openFolder;    
        this.openFile = delegates.openFile;
    }

    changeFolder = async (element) => {
        const data = {
            csrf_token: csrf.getToken(),
            element: {
                id: element.id(),
                name: element.name(),
                path: element.path()
            },
            targetpath: this.path() + this.name() + '/'
        }
        const response = await MediaHandler.updateMediaElement(data);

        if(response.message === 'success') {
            element.path(this.path() + this.name() + '/');
            csrf.updateToken(response.csrfToken);
        }
    }
}