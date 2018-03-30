import ko from 'knockout';
import helpers from '../../helpers';
import MediaPopupMainViewModel from '../MediaPopup/MediaPopupMainViewModel';

export default class PagebuilderElementModel {
    constructor(data) {
        this.mediaPopupVM = ko.observable(new MediaPopupMainViewModel());

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

        const config = this.item_json_config();

        config.elements.forEach(configelement => {
         const newconfigelement = {};
         for(let key in configelement) {
            if(Array.isArray(configelement[key])) {
               const array = ko.observableArray([]);
               configelement[key].forEach((element) => {
                   const newconfigelementarr = {};
                   for(let keyarr in element) {
                       newconfigelementarr[keyarr] = ko.observable(element[keyarr]);
                   }
                   array.push(newconfigelementarr);
               });
               newconfigelement[key] = array;
           } else {
               newconfigelement[key] = ko.observable(configelement[key]);
           }
         }

         const configDB = helpers.isJsonString(data.config) ? JSON.parse(data.config) : data.config;
         if(configDB) {
            configDB.elements.forEach(element => {
               if(element.key === newconfigelement.key()) {
                  if(element.buttons.length > 0) {
                     const buttonArr = ko.observableArray([]);
                     element.buttons.forEach(buttonEl => {
                        const configElementButtonArr = {};
                        for(let keyArr in buttonEl) {
                           configElementButtonArr[keyArr] = ko.observable(buttonEl[keyArr]);
                        }
                        buttonArr.push(configElementButtonArr);
                     });
                     newconfigelement.buttons = buttonArr;
                  } 
                  newconfigelement.value(element.value);
               }
            });
         }
         this.config().elements.push(ko.observable(newconfigelement));
        });
        
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
            if(element().buttons().length > 0) {
                element().value = ko.computed(() => {
                    let html = '';
                    element().buttons().forEach((button) => {
                        if(button.enabled()) {
                            html += button.value();
                        }
                    });
                    return html;
                });
            }
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

    openMediaPopup = (element) => {
        this.mediaPopupVM().openMediaPopup();
        this.mediaPopupVM().selectedMediaElement.subscribe(() => {
            const path = this.mediaPopupVM().selectedMediaElementPath();
            if(path) {
                element.value(path);
            }
        });
    }

    toggleButtonStatus(element) {
        if(element.enabled()) {
            element.enabled(false);
        } else {
            element.enabled(true);
        }
    }

    updateHTML() {
        let html = this.config().html();
        this.config().elements().forEach((element) => {
            html = html.replace(`[${element().key()}]`, element().value());
        });
        this.html(html);
    }
}