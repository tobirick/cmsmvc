import ko from 'knockout';
import MediaHandler from '../../Handlers/MediaHandler';

export default class MediaElementModel {
    constructor(data, delegates) {
        for(let key in data) {
            this[key] = ko.observable(data[key]);
        }

        this.deleteMediaElement = delegates.deleteMediaElement;
        this.openFolder = delegates.openFolder;    
        this.openFile = delegates.openFile;

        this.csrfToken = document.getElementById('csrftoken');
        this.csrfTokenVal = document.getElementById('csrftoken').value;
    }

    updateCSRF(newCsrfToken) {
        this.csrfTokenVal = newCsrfToken;
        this.csrfToken.value = newCsrfToken;
        const csrfTokenInputEls = document.querySelectorAll(
           'input[name="csrf_token"]'
        );
        csrfTokenInputEls.forEach(csrfTokenInputEl => {
           csrfTokenInputEl.value = newCsrfToken;
        });
     }

    changeFolder = async (element) => {
        const data = {
            csrf_token: this.csrfTokenVal,
            element: {
                id: element.id(),
                name: element.name(),
                path: element.path()
            },
            target: {
                id: this.id(),
                name: this.name(),
                path: this.path()
            }
        }
        const response = await MediaHandler.updateMediaElement(data);

        if(response.message === 'success') {
            // do something
        }
    }
}