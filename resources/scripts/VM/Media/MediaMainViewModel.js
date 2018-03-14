import ko from 'knockout';
import 'knockout-sortable';
import MediaElementModel from './MediaElementModel';
import MediaHandler from '../../Handlers/MediaHandler';

export default class MediaManViewModel {
    constructor() {
        this.mediaElements = ko.observableArray([]);
        this.fetchMediaElements();
    }

    async fetchMediaElements() {
        const response = await MediaHandler.fetchMediaElements();

        if (response) {
            response.forEach(mediaElement => {
               this.mediaElements.push(new MediaElementModel(mediaElement, {}));
            });
         }
    }

    openUploadPopup() {
        console.log('open upload popup');
    }

    addFolder() {
        console.log('add folder');
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