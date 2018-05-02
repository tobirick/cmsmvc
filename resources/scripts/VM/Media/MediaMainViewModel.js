import ko from 'knockout';
import MediaElementModel from './MediaElementModel';
import MediaHandler from '../../Handlers/MediaHandler';
import csrf from '../../csrf';
import helpers from '../../helpers';
import loading from '../../loading';

export default class MediaManViewModel {
    constructor() {
        this.fileData = ko.observable({
            file: ko.observable(null),
            dataURL: ko.observable(null),
            fileArray: ko.observableArray([]),
            dataURLArray: ko.observableArray([])
        });
        this.mediaElements = ko.observableArray([]);
        this.currentDir = ko.observable(localStorage.getItem('mediapath') || '/');
        this.pathArr = ko.observableArray([
            { text: '', path: '/' }
        ]);
        this.setBreadcrumbs();

        this.folderPopupOpen = ko.observable(false);
        this.popupOpen = ko.observable(false);
        this.uploadPopupOpen = ko.observable(false);

        this.newFolderName = ko.observable(null);

        this.enableDrop = ko.observable(true);

        this.currentDir.subscribe(() => {
            this.mediaElements([]);
            this.setBreadcrumbs();
            this.fetchMediaElements();
            localStorage.setItem('mediapath', this.currentDir());
        });

        this.imagePreviews = ko.observableArray([]);

        this.fileData().fileArray.subscribe(async (fileArray) => {
            this.imagePreviews([]);
            console.log(ko.toJS(this.fileData));
            if(fileArray.length > 0) {
                const fileArrayToUpload = [];
                for(let fileItem of fileArray) {
                    const file = {
                        name: helpers.mediaElementFormat(decodeURI(fileItem.name)),
                        size: fileItem.size,
                        path: this.currentDir(),
                        base: null
                    };
    
                    await helpers.getBase64(fileItem).then(base64String => {
                        file.base = base64String;
                        fileArrayToUpload.push(file);
                    })

                }
                this.uploadFiles(fileArrayToUpload);
            }

            /*
            const data = ko.toJS(this.fileData);
            if (data.base64String) {
                const file = {
                    name: helpers.mediaElementFormat(decodeURI(data.file.name)),
                    size: data.file.size,
                    path: this.currentDir(),
                    base: data.base64String
                }
                this.uploadFile(file);
            }
            */
        });

        this.baseURL = window.location.origin;

        this.alert = ko.observable({
            visible: ko.observable(false),
            text: ko.observable(),
            type: ko.observable()
        });
    }

    showAlert(type, message) {
        this.alert().visible(true);
        this.alert().type(type);
        this.alert().text(message);

        setTimeout(() => {
            this.alert().visible(false);
        }, 3000);
    }

    closeAlert = () => {
        this.alert().visible(false);
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

    async updatePositions() {
        this.mediaElements().forEach((element, position) => {
            element.position(position);
        });

        const data = {
            csrf_token: csrf.getToken(),
            elements: ko.toJS(this.mediaElements),
            bulk: true
        };

        const response = await MediaHandler.updateMediaElement(data);

        csrf.updateToken(response.csrfToken);
    }

    fetchMediaElements() {
        return MediaHandler.fetchMediaElements(this.currentDir()).then((response) => {
            if (response.message === 'success') {
                response.elements.forEach(mediaElement => {
                    this.mediaElements.push(this.createElement(mediaElement));
                });
            }
        });
    }

    createElement(data) {
        return new MediaElementModel(data, {
            openFolder: this.openFolder,
            openFile: this.openFile,
            changeFolder: this.changeFolder,
            deleteMediaElement: this.deleteMediaElement,
            hoverFile: this.hoverFile,
            removeHoverFile: this.removeHoverFile
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
                name: helpers.mediaElementFormat(this.newFolderName()),
                path: this.currentDir()
            },
            type: 'dir'
        }

        loading.setTarget('.upload-zone');
        loading.addSpinner();
        const response = await MediaHandler.addFolder(data);

        if (response.message === 'success' && !response.error) {
            const folder = this.createElement(response.element);
            this.mediaElements.push(folder);
            this.newFolderName(null);
            this.showAlert('success', 'Folder created');
        } else {
            this.showAlert('error', response.error);
        }
        loading.removeSpinner();
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

        if (response.message === 'success' && !response.error) {
            this.mediaElements.remove(element);
            this.showAlert('success', 'Element deleted');
        } else {
            this.showAlert('error', response.error);
        }
        csrf.updateToken(response.csrfToken);
    }

    async uploadFiles(files) {
        const data = {
            csrf_token: csrf.getToken(),
            files,
            type: 'file'
        }

        
        if(this.enableDrop()) {
            this.enableDrop(false);
            loading.setTarget('.upload-zone');
            loading.addSpinner();
            const response = await MediaHandler.addFiles(data);
    
            if (response.message === 'success' && !response.error) {
                response.element.forEach(uploadedFile => {
                    if(uploadedFile) {
                        this.imagePreviews.push(`/content/media${uploadedFile.path}${uploadedFile.name}`);
                        const file = this.createElement(uploadedFile);
                        this.mediaElements.push(file);
                    }
                })
            } else {
                this.showAlert('error', response.error);
            }
            loading.removeSpinner();
            this.enableDrop(true);
            csrf.updateToken(response.csrfToken);
        }
    }

    openFolder = (element) => {
        this.currentDir(element.path() + element.name() + '/');
    }

    goDirBack() {
        const dirArr = this.currentDir().split('/');
        const newDir = dirArr.slice(0, dirArr.length - 2).join('/') + '/';

        this.currentDir(newDir);
    }

    moveDirBack = async (element) => {
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

        if (response.message === 'success' && !response.error) {
            element.path(newDir);
            this.showAlert('success', 'Element moved');
        } else {
            this.showAlert('error', response.error);
        }
        csrf.updateToken(response.csrfToken);
    }

    changeDir = ({ path }) => {
        this.currentDir(path);
    }

    openFile = (file) => {
        const url = `${this.baseURL}/content/media${file.path()}${file.name()}`;
        const win = window.open(url, '_blank');
        win.focus();
    }

    hoverFile = (file) => {
        file.imagePreview(true);
    }

    removeHoverFile = (file) => {
        file.imagePreview(false);
    }

    async changeFolder(element) {
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

        if (response.message === 'success' && !response.error) {
            element.path(this.path() + this.name() + '/');
        } else {
            //this.showAlert('error', response.error);
            console.log(response.error);
        }
        csrf.updateToken(response.csrfToken);
    }
}