import ko from 'knockout';
import MediaPopupMainViewModel from '../MediaPopup/MediaPopupMainViewModel';
import ThemeHandler from '../../Handlers/ThemeHandler';
import csrf from '../../csrf';
import helpers from '../../helpers';

export default class ThemeMainViewModel {
    constructor() {
        this.themeID = document.getElementById('themeid').value;

        this.headerStyles = ko.observableArray(['nav-right', 'nav-center', 'nav-left']);
        this.maxFooterColumns = 4;

        this.possibleFontFamilies = ko.observableArray(['Roboto', 'Lato', 'Open Sans']);
        this.possibleHeadings = ['h1', 'h2', 'h3', 'h4'];

        this.body = ko.observable('');
        this.possibleHeadings.forEach(heading => {
            this[heading] = ko.observable('')
        });
        this.headingFontFamily = ko.observable('');
        this.headingColor = ko.observable('');
        this.headingLineHeight = ko.observable('');
        this.headingLetterSpacing = ko.observable('');

        this.id = ko.observable('');
        this.name = ko.observable('');
        this.path = ko.observable('');
        this.logo = ko.observable('');
        this.favicon = ko.observable('');
        this.fixed_navigation = ko.observable(Number(0));
        this.google_analytics = ko.observable('');
        this.to_top = ko.observable(Number(0));
        this.header_code = ko.observable('');
        this.body_code = ko.observable('');
        this.header_layout = ko.observable('');
        this.footer_layout = ko.observable('');
        this.google_font = ko.observable('');
        this.custom_scripts = ko.observable('');
        this.custom_styles = ko.observable('');
        this.font_styles = ko.observable('');
        this.default_color = ko.observable('');
        this.footer_bottom = ko.observable('');
        this.css = ko.observable('');

        this.footerColumns = ko.observableArray([]);

        this.mediaPopupVM = ko.observable(new MediaPopupMainViewModel());

        this.alert = ko.observable({
            visible: ko.observable(false),
            text: ko.observable(),
            type: ko.observable()
        });
    }

    setFooterColumns() {
        if (helpers.isJsonString(this.footer_layout())) {
            JSON.parse(this.footer_layout()).columns.forEach(column => {
                this.footerColumns.push({
                    html: ko.observable(column.html),
                    title: ko.observable(column.title)
                })
            });
        } else {
            this.footerColumns([
                {
                    html: ko.observable(''),
                    title: ko.observable('')
                },
                {
                    html: ko.observable(''),
                    title: ko.observable('')
                },
                {
                    html: ko.observable(''),
                    title: ko.observable('')
                },
                {
                    html: ko.observable(''),
                    title: ko.observable('')
                },
            ]);
        }
    }

    setFontStyles() {
        let fontLayout = null;

        if (helpers.isJsonString(this.font_styles())) {
            fontLayout = JSON.parse(this.font_styles());
        } else {
            fontLayout = {
                body: {},
                heading: {},
                h1: {},
                h2: {},
                h3: {},
                h4: {}
            };
        }

        this.headingFontFamily(fontLayout.heading.font_family || '');
        this.headingColor(fontLayout.heading.color || '');
        this.headingLineHeight(fontLayout.heading.line_height || '');
        this.headingLetterSpacing(fontLayout.heading.letter_spacing || '');

        this.body({
            'font_family': ko.observable(fontLayout.body.font_family || ''),
            'font_size': ko.observable(fontLayout.body.font_size || ''),
            'color': ko.observable(fontLayout.body.color || ''),
            'line_height': ko.observable(fontLayout.body.line_height || ''),
            'letter_spacing': ko.observable(fontLayout.body.letter_spacing || '')
        });


        this.possibleHeadings.forEach(heading => {
            const fontSizeString = `fontLayout.${heading}.font_size`;
            this[heading]({
                'font_size': ko.observable(eval(fontSizeString) || '')
            })
        });
    }

    addFooterCol = () => {
        let cols = this.footerColumns();
        if (cols.length < this.maxFooterColumns) {
            this.footerColumns.push({
                html: ko.observable(''),
                title: ko.observable('')
            });
        }
    }

    removeFooterCol = () => {
        let cols = this.footerColumns();
        if (cols.length > 1) {
            this.footerColumns(cols.slice(0, cols.length - 1));
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

    fetchThemeSettings() {
        const data = {
            themeID: this.themeID,
            csrf_token: csrf.getToken(),
        }

        return ThemeHandler.fetchThemeSettings(data).then(response => {
            for (let key in response.theme) {
                this[key](response.theme[key]);
            }
            csrf.updateToken(response.csrfToken);
        }).then(() => {
            this.setFooterColumns();
            this.setFontStyles();
            console.log(this);
        });
    }

    async save() {
        const data = {
            themeID: this.themeID,
            csrf_token: csrf.getToken(),
            theme: ko.toJS(this)
        }

        data.theme.footer_layout = this.generateFooterLayout();
        data.theme.font_styles = this.generateTypography();

        const response = await ThemeHandler.updateThemeSettings(data);
        if (response) {
            this.showAlert('success', 'Theme successfully updated!');
            csrf.updateToken(response.csrfToken);
        }
    }

    generateTypography() {
        let typography = {};
        typography.body = (ko.toJS(this.body));
        typography.heading = {
            font_family: this.headingFontFamily(),
            color: this.headingColor(),
            letter_spacing: this.headingLetterSpacing(),
            line_height: this.headingLineHeight()
        }

        this.possibleHeadings.forEach(heading => {
            typography[heading] = {
                ...ko.toJS(this[heading]),
                font_family: this.headingFontFamily(),
                color: this.headingColor(),
                letter_spacing: this.headingLetterSpacing(),
                line_height: this.headingLineHeight()
            }
        });

        return JSON.stringify(typography);
    }

    generateFooterLayout() {
        let footerLayout = {
            columns: []
        };
        this.footerColumns().forEach(footerColumn => {
            footerLayout.columns.push(ko.toJS(footerColumn));
        });

        return JSON.stringify(footerLayout);
    }

    openMediaPopup = (element) => {
        this.mediaPopupVM().openMediaPopup();
        const subscription = this.mediaPopupVM().selectedMediaElement.subscribe(() => {
            const path = this.mediaPopupVM().selectedMediaElementPath();
            if (path) {
                element(path);
            } else {
                subscription.dispose();
            }
        });
    }
}