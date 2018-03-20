import ko from 'knockout';
import 'knockout-sortable';
import 'knockout-file-bindings';
import MediaElementModel from './MediaElementModel';
import MediaHandler from '../../Handlers/MediaHandler';
import csrf from '../../csrf';
import helpers from '../../helpers';

export default class MediaManViewModel {
    constructor() {
        this.fileData = ko.observable({
            text: ko.observable(null),
            dataURL: ko.observable(null),
            file: ko.observable(null),
            base64String: ko.observable(null)
        });
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

        this.currentDir.subscribe(() => {
            this.mediaElements([]);
            this.setBreadcrumbs();
            this.fetchMediaElements();
            localStorage.setItem('mediapath', this.currentDir());
        });

        this.fileData().base64String.subscribe(() => {
            const data = ko.toJS(this.fileData);
            console.log(data);
            if(data.base64String) {
                const file = { 
                    name: helpers.deUmlaut(data.file.name),
                    size: data.file.size,
                    path: this.currentDir(),
                    base: data.base64String
                }
    
                this.uploadFile(file);
            }
        });

        this.baseURL = 'http://testseite.local:8081';
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

    async fetchMediaElements() {
        const response = await MediaHandler.fetchMediaElements(this.currentDir());

        if (response.message === 'success') {
            response.elements.forEach(mediaElement => {
               this.mediaElements.push(this.createElement(mediaElement));
            });
         }
    }

    createElement(data) {
        return new MediaElementModel(data, {
            openFolder: this.openFolder,
            openFile: this.openFile,
            deleteMediaElement: this.deleteMediaElement,
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
            csrf_token: csrf.getToken(),
            folder: {
                name: this.newFolderName(),
                path: this.currentDir()
            },
            type: 'dir'
        }
    
        const response = await MediaHandler.addFolder(data);

        if(response.message === 'success' && !response.error) {
            const folder = this.createElement(response.element);
            this.mediaElements.push(folder);
            this.newFolderName(null);
    
         } else {
            console.log(response.error);
         }
         csrf.updateToken(response.csrfToken);
    }

    deleteMediaElement = async (element) => {
        const data = {
            csrf_token: csrf.getToken(),
            element: {
                id: element.id()
            }
        }
        const response = await MediaHandler.deleteMediaElement(data);

        if(response.message === 'success') {
            this.mediaElements.remove(element);
            csrf.updateToken(response.csrfToken);
        }
    }

    async uploadFile(file) {
        const data = {
            csrf_token: csrf.getToken(),
            file,
            type: 'file'
        }
    
        const response = await MediaHandler.addFile(data);

        if(response.message === 'success' && !response.error) {
            const file = this.createElement(response.element);
            this.mediaElements.push(file);
    
         } else {
            console.log(response.error);
         }
         csrf.updateToken(response.csrfToken);
    }

    openFolder = (element) => {
        this.currentDir(element.path() + element.name() + '/');
    }

    goDirBack() {
        const dirArr = this.currentDir().split('/');
        const newDir = dirArr.slice(0, dirArr.length - 2).join('/') + '/';

        this.currentDir(newDir);
    }

    async moveDirBack(element) {
        const dirArr = element.path().split('/');
        const newDir = dirArr.slice(0, dirArr.length - 2).join('/') + '/';

        const data = {
            csrf_token: csrf.getToken(),
            element: {
                id: element.id(),
                name: element.name(),
                path: element.path()
            },
            targetpath: newDir
        }

        const response = await MediaHandler.updateMediaElement(data);
        
        if(response.message === 'success' && !response.error) {
            element.path(newDir);
        } else {
            console.log(response.error);
        }
        csrf.updateToken(response.csrfToken);
    }

    changeDir = ({path}) => {
        this.currentDir(path);
    }

    openFile = (file) => {
        const url = `${this.baseURL}/content/media${file.path()}${file.name()}`;
        const win = window.open(url, '_blank');
        win.focus();
    }
}