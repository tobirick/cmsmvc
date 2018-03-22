import ko from 'knockout';
import helpers from '../../helpers';

export default class PagebuilderField {
    constructor(data, delegates) {
        this.name = ko.observable(data.name || '');
        this.type = ko.observable(data.type || '');
        this.key = ko.observable(data.key || '');
        this.value = ko.observable(data.value || '');

        this.name.subscribe(() => {
            this.key(helpers.mediaElementFormat(this.name()));
        });
    }
}