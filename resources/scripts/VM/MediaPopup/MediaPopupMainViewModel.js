import ko from 'knockout';
import MediaHandler from '../../Handlers/MediaHandler';
import MediaElementModel from '../Media/MediaElementModel';
import helpers from '../../helpers';
import csrf from '../../csrf';
import loading from '../../loading';

export default class MediaPopupMainViewModel {
    constructor() {
        this.mediaElements = ko.observableArray([]);
        this.fetchMediaElements();
        this.filterQuery = ko.observable('');
        this.excludeMediaImages = ko.observable(false);

        this.mediaPopupOpen = ko.observable(false);
        this.uploadPopupOpen = ko.observable(false);
        this.fileData = ko.observable({
            file: ko.observable(null),
            dataURL: ko.observable(null),
            fileArray: ko.observableArray([]),
            dataURLArray: ko.observableArray([])
        });
        this.imagePreviews = ko.observableArray([]);

        this.fileData().fileArray.subscribe(async (fileArray) => {
            this.imagePreviews([]);
            if(fileArray.length > 0) {
                const fileArrayToUpload = [];
                for(let fileItem of fileArray) {
                    const file = {
                        name: helpers.mediaElementFormat(decodeURI(fileItem.name)),
                        size: fileItem.size,
                        path: '/',
                        base: null
                    };
    
                    await helpers.getBase64(fileItem).then(base64String => {
                        file.base = base64String;
                        fileArrayToUpload.push(file);
                    })

                }
                this.uploadFiles(fileArrayToUpload);
            }
        });

        this.selectedMediaElement = ko.observable(null);
        this.selectedMediaElementPath = ko.computed(() => {
            if (this.selectedMediaElement()) {
                return '/content/media' + this.selectedMediaElement().path + this.selectedMediaElement().name;
            }
        });

        this.filteredMediaElements = ko.computed(() => {
            const search = this.filterQuery().toLowerCase();
            const filtered = this.mediaElements().filter(element => {
                return (this.excludeMediaImages() ? (element.name.indexOf('@2x') === -1 && element.name.indexOf('@3x') === -1) : true) && (element.name.toLowerCase().indexOf(search) >= 0 || element.path.toLowerCase().indexOf(search) >= 0);
            });
            return filtered;
        })
    }

    async fetchMediaElements() {
        const response = await MediaHandler.fetchImages();

        if (response.message === 'success') {
            response.elements.forEach(mediaElement => {
                this.mediaElements.push(mediaElement);
            });
        }
    }

    openMediaPopup = () => {
        this.mediaPopupOpen(true);
    }

    closeMediaPopup = () => {
        this.mediaPopupOpen(false);
        this.selectedMediaElement(null);
        console.log(this);
    }

    setMediaElement = (element) => {
        this.selectedMediaElement(element);
    }

    setInitialMediaElement = (path) => {
        const element = this.mediaElements().find(mediaElement => {
            return '/content/media' + mediaElement.path + mediaElement.name === path;
        });
        this.setMediaElement(element);
    }

    getActiveMediaElementURL() {
        return '/content/media' + this.selectedMediaElement().path + this.selectedMediaElement().name;
    }

    closePopup() {
        this.uploadPopupOpen(false);
    }
    
    async uploadFiles(files) {
        const data = {
            csrf_token: csrf.getToken(),
            files,
            type: 'file'
        }

        loading.setTarget('.upload-zone');
            loading.addSpinner();
            const response = await MediaHandler.addFiles(data);
    
            if (response.message === 'success' && !response.error) {
                response.element.forEach(uploadedFile => {
                    if(uploadedFile) {
                        this.imagePreviews.push(`/content/media${uploadedFile.path}${uploadedFile.name}`);
                        this.mediaElements.unshift(uploadedFile);
                    }
                })
            } else {
                console.log(reponse.error);
            }

            loading.removeSpinner();
            csrf.updateToken(response.csrfToken);
    }

    openUploadPopup() {
        this.uploadPopupOpen(true);
    }
}