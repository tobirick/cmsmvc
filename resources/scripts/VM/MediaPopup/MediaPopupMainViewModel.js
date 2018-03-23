import ko from 'knockout';
import MediaHandler from '../../Handlers/MediaHandler';

export default class MediaPopupMainViewModel {
    constructor() {
        this.mediaElements = ko.observableArray([]);
        this.fetchMediaElements();

        this.mediaPopupOpen = ko.observable(false);

        this.selectedMediaElement = ko.observable(null);
        this.selectedMediaElementPath = ko.computed(() => {
            if(this.selectedMediaElement()) {
                return '/content/media' + this.selectedMediaElement().path + this.selectedMediaElement().name;
            }
        });
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
    }

    setMediaElement = (element) => {
        this.selectedMediaElement(element);
    }

    getActiveMediaElementURL() {
        return '/content/media' + this.selectedMediaElement().path + this.selectedMediaElement().name;
    }
}