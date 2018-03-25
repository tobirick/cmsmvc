import ko from 'knockout';
import csrf from '../../csrf';
import helpers from '../../helpers';

import PagebuilderItem from './PagebuilderItem';
import PagebuilderField from './PagebuilderField';
import PagebuilderHandler from '../../Handlers/PagebuilderHandler';

export default class CreatePagebuilderMainViewModel {
    constructor() {
        this.possibleFieldTypes = ko.observableArray([
            'textarea', 'color', 'range', 'font-style', 'font-orientation', 'number', 'text', 'image-src', 'button-row'
        ]);
        this.fields = ko.observableArray([]);
        this.pagebuilderItem = ko.observable();
        this.pagebuilderIDItem = document.getElementById('pagebuilderitemid');
        this.pagebuilderID = this.pagebuilderIDItem ? this.pagebuilderIDItem.value : '';

        if(this.pagebuilderID) {
            this.fetchPagebuilderItem();
        } else {
            const data = {
                item_name: '',
                item_html: '',
                item_type: '',
                item_json_config: ''
            };

            this.pagebuilderItem(this.addPagebuilderItem(data));
        }

        this.alert = ko.observable({
            visible: ko.observable(false),
            text: ko.observable(),
            type: ko.observable()
        });

        this.popupOpen = ko.observable(false);

        this.selectedField = ko.observable(null);
    }

    copyToClipboard = (element) => {
        const copy = document.createElement("input");
        document.body.appendChild(copy);
        copy.setAttribute("id", "copy");
        document.getElementById("copy").value = '[' + element.key() + ']';

        copy.select();
        document.execCommand("copy");
        document.body.removeChild(copy);

        this.showAlert('success', 'Copied to Clipboard!');
    }

    closePopup = () => {
        this.popupOpen(false);
        this.selectedField(null);
    }

    openPopup = (field) => {
        this.popupOpen(true);
        if(field instanceof PagebuilderField) {
            this.selectedField(field);
        } else {
            this.pagebuilderItem().setDefaultField();
            this.selectedField(this.pagebuilderItem().defaultField);
        }
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

    async saveToDB() {
        await this.pagebuilderItem().updateConfig();
        const data = {
            csrf_token: csrf.getToken(),
            pagebuilderitem: ko.toJS(this.pagebuilderItem)
        }

        if(this.pagebuilderID) {
            data.pagebuilderID = this.pagebuilderID;
            const response = await PagebuilderHandler.updatePagebuilderItem(data);
            if(response) {
                csrf.updateToken(response.csrfToken);
                this.showAlert('success', 'Item successfully updated!');
            }
        } else {
            const response = await PagebuilderHandler.addPagebuilderItem(data);
            this.pagebuilderID = response.pagebuilderID;

            if(response) {
                csrf.updateToken(response.csrfToken);
                this.showAlert('success', 'Item successfully added!');
            }
        }       
    }

    addPagebuilderItem(data) {
        return new PagebuilderItem(data);
    }

    removeField = (element) => {
        this.pagebuilderItem().configVM().elements.remove(element);
    }

    async fetchPagebuilderItem() {
        const data = {
            csrf_token: csrf.getToken(),
            pagebuilderID: this.pagebuilderID
        }
    
        const response = await PagebuilderHandler.getPagebuilderItemByID(data);

        if(response.message === 'success' && !response.error) {
            this.pagebuilderItem(this.addPagebuilderItem(response.pagebuilderitem));
         }

         csrf.updateToken(response.csrfToken);
    }
}