import ko from 'knockout';
import 'knockout-sortable';
import MediaElementModel from './MediaElementModel';
import MediaHandler from '../../Handlers/MediaHandler';

export default class MediaManViewModel {
    constructor() {
        this.mediaElements = ko.observableArray([]);
        this.currentDir = ko.observable(localStorage.getItem('mediapath') || '/');
        this.pathArr = ko.observableArray([
            {text: '', path: '/'}
        ]);
        this.setBreadcrumbs();
        this.fetchMediaElements();

        this.folderPopupOpen = ko.observable(false);
        this.popupOpen = ko.observable(false);
        this.uploadPopupOpen = ko.observable(false);

        this.newFolderName = ko.observable(null);

        this.csrfToken = document.getElementById('csrftoken');
        this.csrfTokenVal = document.getElementById('csrftoken').value;

        this.currentDir.subscribe(() => {
            this.mediaElements([]);
            this.setBreadcrumbs();
            this.fetchMediaElements();
            localStorage.setItem('mediapath', this.currentDir());
        });
    }

    setBreadcrumbs() {
        this.pathArr([]);
        let paths = this.currentDir().split('/');

        let lastPaths = '';
        paths.splice(0, paths.length - 1).forEach(path => {
            lastPaths += path + '/';
            this.pathArr.push({
                text: path,
                path: lastPaths
            })
        });
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
        const response = await MediaHandler.fetchMediaElements(this.currentDir());

        console.log(response);

        if (response.message === 'success') {
            response.elements.forEach(mediaElement => {
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
            element: {
                id: element.id()
            }
        }
        const response = await MediaHandler.deleteMediaElement(data);

        if(response.message === 'success') {
            this.mediaElements.remove(element);
            this.updateCSRF(response.csrfToken);
        }
    }

    uploadFile() {
        console.log('upload');
    }

    addFile() {
        console.log('add file');
    }

    openFolder = (element) => {
        console.log('open folder');
        this.currentDir(element.path() + element.name() + '/');
    }

    goDirBack() {
        let newDir;

        const dirArr= this.currentDir().split('/');
        newDir = dirArr.slice(0, dirArr.length - 2).join('/') + '/';

        this.currentDir(newDir);
    }

    changeDir = ({path}) => {
        this.currentDir(path);
    }

    openFile() {
        console.log('open file');
    }
}