import ko from 'knockout';
import MediaHandler from '../../Handlers/MediaHandler';

export default class MediaPopupMainViewModel {
    constructor() {
        this.mediaElements = ko.observableArray([]);
        this.fetchMediaElements();
        this.filterQuery = ko.observable('');
        this.excludeMediaImages = ko.observable(false);

        this.mediaPopupOpen = ko.observable(false);

        this.selectedMediaElement = ko.observable(null);
        this.selectedMediaElementPath = ko.computed(() => {
            if (this.selectedMediaElement()) {
                return '/content/media' + this.selectedMediaElement().path + this.selectedMediaElement().name;
            }
        });

        this.filteredMediaElements = ko.computed(() => {
            const search = this.filterQuery().toLowerCase();
            const filtered = this.mediaElements().filter(element => {
                if(this.excludeMediaImages()) {
                    return (element.name.indexOf('@2x') === -1 && element.name.indexOf('@3x') === -1) && (element.name.toLowerCase().indexOf(search) >= 0 || element.path.toLowerCase().indexOf(search) >= 0);
                } else {
                    return (element.name.toLowerCase().indexOf(search) >= 0 || element.path.toLowerCase().indexOf(search) >= 0);
                }
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
    }

    setMediaElement = (element) => {
        this.selectedMediaElement(element);
    }

    getActiveMediaElementURL() {
        return '/content/media' + this.selectedMediaElement().path + this.selectedMediaElement().name;
    }
}