import ko from 'knockout';
import 'knockout-sortable';
import MediaElementModel from './MediaElementModel';
import MediaHandler from '../../Handlers/MediaHandler';

export default class MediaManViewModel {
    constructor() {
        this.mediaElements = ko.observableArray([]);
        this.fetchMediaElements();

        this.folderPopupOpen = ko.observable(false);
        this.popupOpen = ko.observable(false);
        this.uploadPopupOpen = ko.observable(false);

        this.currentDir = ko.observable('/');

        this.newFolderName = ko.observable(null);

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

    async fetchMediaElements() {
        const response = await MediaHandler.fetchMediaElements();

        console.log(response);
        if (response) {
            response.forEach(mediaElement => {
               this.mediaElements.push(this.createElement(mediaElement));
            });
         }
    }

    createElement(data) {
        return new MediaElementModel(data, {
            openFolder: this.openFolder,
            changeFolder: this.changeFolder,
            openFile: this.openFile,
            deleteMediaElement: this.deleteMediaElement
        })
    }

    openUploadPopup() {
        this.popupOpen(true);
        this.uploadPopupOpen(true);
    }

    openAddFolderPopup() {
        this.popupOpen(true);
        this.folderPopupOpen(true);
    }

    closePopup() {
        this.popupOpen(false);
        this.folderPopupOpen(false);
        this.uploadPopupOpen(false);
    }

    async createFolder() {
        const data = {
            csrf_token: this.csrfTokenVal,
            folder: {
                name: this.newFolderName(),
                path: this.currentDir()
            },
            type: 'dir'
        }
    
        const response = await MediaHandler.addFolder(data);

        if(response.message === 'success') {
            const folder = this.createElement(response.element);
            this.mediaElements.push(folder);
    
            this.updateCSRF(response.csrfToken);
        }
    }

    deleteMediaElement = async (element) => {
        const data = {
            csrf_token: this.csrfTokenVal,
            element: {...ko.toJS(element)}
        }
        const response = await MediaHandler.deleteMediaElement(data);

        if(response.message === 'success') {
            this.mediaElements.remove(element);
            this.updateCSRF(response.csrfToken);
        }
    }

    changeFolder() {
        console.log('change folder');
    }

    uploadFile() {
        console.log('upload');
    }

    addFile() {
        console.log('add file');
    }

    openFolder() {
        console.log('open folder');
    }

    openFile() {
        console.log('open file');
    }
}