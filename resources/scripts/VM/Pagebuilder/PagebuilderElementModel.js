import ko from 'knockout';
import helpers from '../../helpers';

export default class PagebuilderElementModel {
    constructor(data) {
        this.item_name = ko.observable(data.item_name);
        this.item_type = ko.observable(data.item_type);
        this.item_html = ko.observable(data.item_html);
        this.item_json_config = ko.observable(helpers.isJsonString(data.item_json_config) ? JSON.parse(data.item_json_config) : data.item_json_config);

        this.id = ko.observable(data.id || '');
        this.column_id = ko.observable(data.column_id || '');
        this.item_id = ko.observable(data.item_id || '');
        this.name = ko.observable(data.name || '');
        this.css_class = ko.observable(data.css_class || '');
        this.css_id = ko.observable(data.css_id || '');
        this.styles = ko.observable(data.styles || '');
        this.bg_color = ko.observable(data.bg_color || '');
        this.html = ko.observable(data.html || '');
        this.config = ko.observable({
            elements: ko.observableArray([]),
            html: ko.observable(this.item_html())
        });

        const config = !data.config ? this.item_json_config() : helpers.isJsonString(data.config) ? JSON.parse(data.config) : data.config;

        if(config.elements) {
            config.elements.forEach(configelement => {
                const newconfigelement = {};
                for(let key in configelement) {
                    newconfigelement[key] = ko.observable(configelement[key]);
                }
                this.config().elements.push(ko.observable(newconfigelement));
            });
        }
  
        this.paddingVM = ko.observable(data.paddingVM ? {
            top: ko.observable(data.paddingVM.top || ''),
            right: ko.observable(data.paddingVM.right || ''),
            bottom: ko.observable(data.paddingVM.bottom || ''),
            left: ko.observable(data.paddingVM.left || '')
        } : {
          top: ko.observable(''),
          right: ko.observable(''),
          bottom: ko.observable(''),
          left: ko.observable('')
        });
        
        this.marginVM = ko.observable(data.marginVM ? {
            top: ko.observable(data.marginVM.top || ''),
            right: ko.observable(data.marginVM.right || ''),
            bottom: ko.observable(data.marginVM.bottom || ''),
            left: ko.observable(data.marginVM.left || '')
        } : {
          top: ko.observable(''),
          right: ko.observable(''),
          bottom: ko.observable(''),
          left: ko.observable('')
        });

        this.config().elements().forEach((element) => {
            element().value.subscribe(() => {
                this.updateHTML();
            })
        });
  
        this.padding = ko.computed(() => {
            return `${this.paddingVM().top()} ${this.paddingVM().right()} ${this.paddingVM().bottom()} ${this.paddingVM().left()}`;
        })
  
        this.margin = ko.computed(() => {
          return `${this.marginVM().top()} ${this.marginVM().right()} ${this.marginVM().bottom()} ${this.marginVM().left()}`;
          })

          this.generatedHTML = ko.computed(() => {
            return `<div
                    ${this.css_class() !== '' ? `class="${this.css_class()}"` :''}
                    ${this.css_id() !== '' ? `id="${this.css_id()}"` :''}
                    style="${this.styles()}
                    ${this.bg_color() !== '' ? `background-color:${this.bg_color()};` : ''}
                    ${this.paddingVM().top() !== '' ? `padding-top:${this.paddingVM().top()};` : ''}
                    ${this.paddingVM().right() !== '' ? `padding-right:${this.paddingVM().right()};` : ''}
                    ${this.paddingVM().bottom() !== '' ? `padding-bottom:${this.paddingVM().bottom()};` : ''}
                    ${this.paddingVM().left() !== '' ? `padding-left:${this.paddingVM().left()};` : ''}
                    ${this.marginVM().top() !== '' ? `margin-top:${this.marginVM().top()};` : ''}
                    ${this.marginVM().right() !== '' ? `margin-right:${this.marginVM().right()};` : ''}
                    ${this.marginVM().bottom() !== '' ? `margin-bottom:${this.marginVM().bottom()};` : ''}
                    ${this.marginVM().left() !== '' ? `margin-left:${this.marginVM().left()};` : ''}
                    ">
                    ${this.html()}
                    </div>
                    `;
        });
    }

    updateHTML() {
        let html = this.config().html();
        this.config().elements().forEach((element) => {
            html = html.replace(`[${element().key()}]`, element().value());
        });
        this.html(html);
    }
}