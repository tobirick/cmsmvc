import ko from 'knockout';
import PagebuilderRowModel from './PagebuilderRowModel';

export default class PagebuilderSectionModel {
    constructor(data, delegates) {
        this.bgImageSizeOptions = ko.observableArray([
            'cover', 'contain', 'auto'
        ]);

        this.bgImagePositionOptions = ko.observableArray([
            'left top', 'left center', 'left bottom', 'right top', 'right center', 'right bottom', 'center top', 'center center', 'center bottom'
        ]);

        this.bgImageRepeatOptions = ko.observableArray([
            'no-repeat', 'repeat', 'repeat-x', 'repeat-y', 'space', 'round'
        ]);

        this.bgGradientTypes = ko.observableArray([
            'linear-gradient'
        ]);

        this.id = ko.observable(data.id || '');
        this.language_id = ko.observable(data.language_id || '');
        this.name = ko.observable(data.name || '');
        this.position = ko.observable(data.position || '');
        this.css_class = ko.observable(data.css_class || '');
        this.css_id = ko.observable(data.css_id || '');
        this.styles = ko.observable(data.styles || '');
        this.full_width = ko.observable(parseInt(data.full_width) || 0);
        this.bg_color = ko.observable(data.bg_color || '');
        this.bg_image = ko.observable(data.bg_image || '');
        this.bg_image_size = ko.observable(data.bg_image_size || '');
        this.bg_image_position = ko.observable(data.bg_image_position || '');
        this.bg_image_repeat = ko.observable(data.bg_image_repeat || '');

        this.bg_gradient_first_color = ko.observable(data.bg_gradient_first_color || '');
        this.bg_gradient_second_color = ko.observable(data.bg_gradient_second_color || '');
        this.bg_gradient_type = ko.observable(data.bg_gradient_type || 'linear-gradient');
        this.bg_gradient_direction = ko.observable(data.bg_gradient_direction || '');
        this.bg_gradient_start_position = ko.observable(data.bg_gradient_start_position || '');
        this.bg_gradient_end_position = ko.observable(data.bg_gradient_end_position || '');

        this.current_bg_mode = ko.observable(data.current_bg_mode || 'color');

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

        this.bgGradient = ko.computed(() => {
            return `${this.bg_gradient_type()}(${this.bg_gradient_direction()}deg,${this.bg_gradient_first_color()} ${this.bg_gradient_start_position()}%, ${this.bg_gradient_second_color()} ${this.bg_gradient_end_position()}%)`;
        })

        this.html = ko.computed(() => {
            const style = `${this.styles()} 
                            ${this.bg_image() !== '' && this.current_bg_mode() === 'image' ? `background-image:url(${this.bg_image()});background-size:${this.bg_image_size()};background-position:${this.bg_image_position()};background-repeat:${this.bg_image_repeat()};` : ''}
                            ${this.bg_color() !== '' && this.current_bg_mode() === 'color' ? `background-color:${this.bg_color()};` : ''}
                            ${this.current_bg_mode() === 'gradient' ? `background-image:${this.bgGradient()};` : ''}
                            ${this.paddingVM().top() !== '' ? `padding-top:${this.paddingVM().top()}rem;` : ''}
                            ${this.paddingVM().right() !== '' ? `padding-right:${this.paddingVM().right()}rem;` : ''}
                            ${this.paddingVM().bottom() !== '' ? `padding-bottom:${this.paddingVM().bottom()}rem;` : ''}
                            ${this.paddingVM().left() !== '' ? `padding-left:${this.paddingVM().left()}rem;` : ''}
                            ${this.marginVM().top() !== '' ? `margin-top:${this.marginVM().top()}rem;` : ''}
                            ${this.marginVM().right() !== '' ? `margin-right:${this.marginVM().right()}rem;` : ''}
                            ${this.marginVM().bottom() !== '' ? `margin-bottom:${this.marginVM().bottom()}rem;` : ''}
                            ${this.marginVM().left() !== '' ? `margin-left:${this.marginVM().left()}rem;` : ''}`;

            return `<section 
                    ${this.css_class() !== '' ? `class="${this.css_class()}"` : ''}
                    ${this.css_id() !== '' ? `id="${this.css_id()}"` : ''} 
                    ${style.trim() !== '' ? `style="${style.trim()}"` : ''}>
                    ${this.full_width() ? '<div class="container-fluid">' : '<div class="container">'}`;
        });

        this.rows = ko.observableArray([]);

        if (ko.toJS(this.id)) {
            data.rows.forEach(row => {
                const paddingArr = row.padding.split(' ');
                const marginArr = row.margin.split(' ');
                const paddingVM = { top: paddingArr[0], right: paddingArr[1], bottom: paddingArr[2], left: paddingArr[3] };
                const marginVM = { top: marginArr[0], right: marginArr[1], bottom: marginArr[2], left: marginArr[3] };
                this.rows.push(this.newRow({ ...row, paddingVM, marginVM }));
            });
        } else if (data.rows) {
            data.rows.forEach(row => {
                this.rows.push(this.newRow({ ...row, id: '' }));
            });
        } else {
            this.rows.push(this.newRow({}));
        }

        this.deleteSection = delegates.deleteSection;
        this.cloneSection = delegates.cloneSection;

        this.deletedRows = [];
    }

    changeBackgroundMode = (newMode) => {
        const spContainerEls = document.querySelectorAll('.sp-container');
        spContainerEls.forEach(spContainerEl => {
            spContainerEl.parentNode.removeChild(spContainerEl);
        });
        this.current_bg_mode(newMode);
    }

    deleteRow = row => {
        this.deletedRows.push(row.id());
        this.rows.remove(row);
    };

    cloneRow = row => {
        const index = this.rows.indexOf(row) + 1;
        this.rows.splice(
            index,
            0,
            this.newRow({ ...ko.toJS(row), id: '' })
        );
    };

    addRow() {
        this.rows.push(this.newRow({}));
    }

    newRow = (data) => {
        return new PagebuilderRowModel(data,
            {
                deleteRow: this.deleteRow,
                cloneRow: this.cloneRow
            }
        );
    }
}