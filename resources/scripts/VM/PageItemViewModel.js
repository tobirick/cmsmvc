import ko from 'knockout';

export default class PageItemViewModel {
    constructor(data) {
        for(let key in data) {
            this[key] = data[key];
        }
    }
}