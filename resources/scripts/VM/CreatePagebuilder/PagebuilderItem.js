import ko from 'knockout';
import helpers from '../../helpers';
import PagebuilderField from './PagebuilderField';

export default class PagebuilderItem {
    constructor(data) {
        this.name = ko.observable(data.item_name);
        this.html = ko.observable(data.item_html);
        this.type = ko.observable(data.item_type);
        this.config = ko.observable(data.item_json_config);

        this.configVM = ko.observable({
            elements: ko.observableArray([])
        })

        const config =  helpers.isJsonString(this.config()) ? JSON.parse(this.config()) : this.config();

        if(config.elements) {
            config.elements.forEach(configelement => {
                this.addPagebuilderField(configelement);
            });
        }

        this.defaultField = ko.observable(null);
    }

    setDefaultField() {
        this.defaultField(this.addPagebuilderField({}));
    }

    addPagebuilderField(data) {
        const newElement = new PagebuilderField(ko.toJS(data), {
            removeField: this.removeField
        });
        this.configVM().elements.push(newElement);

        return newElement;
    }

    removeField = (element) => {
        this.configVM().elements.remove(element);
    }

    updateConfig() {
        const config = ko.toJS(this.configVM);
        const newconfig = {
            elements: config.elements
        }

        this.config(JSON.stringify(newconfig));
    }
}