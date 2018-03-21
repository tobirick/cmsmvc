import ko from 'knockout';

export default class PagebuilderElementModel {
    constructor(data) {
        this.item_name = ko.observable(data.item_name);
        this.item_path_name = ko.observable(data.item_path_name);
        this.item_content = ko.observable(data.item_content);
        this.item_type = ko.observable(data.item_type);
        this.item_description = ko.observable(data.item_description);
        this.item_html = ko.observable(data.item_html);

        this.id = ko.observable(data.id || '');
        this.column_id = ko.observable(data.column_id || '');
        this.item_id = ko.observable(data.item_id || '');
        this.name = ko.observable(data.name || '');
        this.css_class = ko.observable(data.css_class || '');
        this.css_id = ko.observable(data.css_id || '');
        this.styles = ko.observable(data.styles || '');
        this.bg_color = ko.observable(data.bg_color || '');
  
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
  
        this.padding = ko.computed(() => {
            return `${this.paddingVM().top()} ${this.paddingVM().right()} ${this.paddingVM().bottom()} ${this.paddingVM().left()}`;
        })
  
        this.margin = ko.computed(() => {
          return `${this.marginVM().top()} ${this.marginVM().right()} ${this.marginVM().bottom()} ${this.marginVM().left()}`;
          })

          this.html = ko.observable(null);

          this.generatedHTML = ko.computed(() => {
            return `<div class="${this.css_class()}" id="${this.css_id()}" styles="${this.styles()} background-color:${this.bg_color()};
                    padding-top:${this.paddingVM().top()}; padding-right:${this.paddingVM().right()}; padding-bottom:${this.paddingVM().bottom()}; padding-left:${this.paddingVM().left()};
                    margin-top:${this.marginVM().top()}; margin-right:${this.marginVM().right()}; margin-bottom:${this.marginVM().bottom()}; margin-left:${this.marginVM().left()};">
                    ${this.html()}
                    </div>
                    `;
        });
    }

    updateHTML = (data) => {

    }
}