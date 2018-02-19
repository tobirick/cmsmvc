import ko from 'knockout';

export default class MenuListItemsViewModel {
    constructor(data) {
        for(let key in data) {
            this[key] = ko.observable(data[key]);
        }

        this.selectedPage = ko.observable(data.page_id);

        console.log(this.selectedPage());

        this.selectedPage.subscribe(function(selectedData) {
            this.selectedPage = selectedData.id();
        });
    }

    addMenuListItem() {

    }

    delteMenuListItem() {

    }

    updateMenuListItem() {

    }
}