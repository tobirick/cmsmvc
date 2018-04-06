import ko from 'knockout';
import $ from 'jquery';
import 'knockout-sortable';
import 'knockout-file-bindings';
import 'jquery-ui';
import 'spectrum-colorpicker';
import './bindings';

import { validator } from './validate';
import loading from './loading';

import Sidebar from './admin-sidebar';
import Form from './admin-form';
import MenuListMainViewModel from './VM/MenuListItems/MenuListMainViewModel';
import PagebuilderMainViewModel from './VM/Pagebuilder/PagebuilderMainViewModel';
import MediaMainViewModel from './VM/Media/MediaMainViewModel';
import CreatePagebuilderMainViewModel from './VM/CreatePagebuilder/CreatePagebuilderMainViewModel';
import ThemeMainViewModel from './VM/Theme/ThemeMainViewModel';
import UserRolesMainViewModel from './VM/UserRoles/UserRolesMainViewModel';
import MediaPopupMainViewModel from './VM/MediaPopup/MediaPopupMainViewModel';
import TranslationsMainViewModel from './VM/Translations/TranslationsMainViewModel';

// Validator
validator.init('#validate-form').addBasicRules();
const sidebar = new Sidebar();
const form = new Form();

// Knockout VieModels
const pathName = window.location.pathname;
// User Roles
if (pathName.includes('/admin/users/roles')) {
    const userRolesMainViewModel = new UserRolesMainViewModel();
    loading.addSpinner();
    userRolesMainViewModel.fetchUserRoles()
        .then(() => userRolesMainViewModel.fetchUserPermissions())
        .then(() => {
            ko.applyBindings(userRolesMainViewModel);
            loading.removeSpinner();
        });
}

// Edit Menu Page
if (pathName.includes('/admin/menus/') && pathName.includes('edit')) {
    const menuListMainViewModel = new MenuListMainViewModel();
    ko.bindingHandlers.sortable.afterMove = (args) => {
        menuListMainViewModel.updateMenuPositions(args);
    }
    loading.addSpinner();
    menuListMainViewModel.getPages()
        .then(() => menuListMainViewModel.fetchLanguages())
        .then(() => menuListMainViewModel.getMenuListItems())
        .then(() => {
            ko.applyBindings(menuListMainViewModel);
            loading.removeSpinner();
        });
}

// Pagebuilder
if (pathName.includes('/admin/pages/') && pathName.includes('edit')) {
    const pagebuilderMainViewModel = new PagebuilderMainViewModel();
    ko.bindingHandlers.sortable.afterMove = (args) => {
        pagebuilderMainViewModel.setPossibleColumns();
    }
    loading.addSpinner();
    pagebuilderMainViewModel.fetchPage()
        .then(() => pagebuilderMainViewModel.fetchLanguages())
        .then(() => pagebuilderMainViewModel.getPageBuilderElements())
        .then(() => pagebuilderMainViewModel.fetchSections())
        .then(() => {
            ko.applyBindings(pagebuilderMainViewModel);
            loading.removeSpinner();
        });
}

// Media
if (pathName.includes('/admin/media')) {
    const mediaMainViewModel = new MediaMainViewModel();
    ko.bindingHandlers.sortable.afterMove = () => {
        mediaMainViewModel.updatePositions();
    }
    loading.addSpinner();
    mediaMainViewModel.fetchMediaElements()
        .then(() => {
            ko.applyBindings(mediaMainViewModel);
            loading.removeSpinner();
        });
}

// Add/Edit Pagebuilder
if (pathName.includes('/admin/pagebuilder/')) {
    const createPagebuilderMainViewModel = new CreatePagebuilderMainViewModel();
    ko.applyBindings(createPagebuilderMainViewModel);
}

// Theme
if (pathName.includes('/admin/themes/') && pathName.includes('edit')) {
    const themeMainViewModel = new ThemeMainViewModel();
    loading.addSpinner();
    themeMainViewModel.fetchThemeSettings()
        .then(() => {
            ko.applyBindings(themeMainViewModel);
            loading.removeSpinner();
        })
}

// Translations
if (pathName.includes('/admin/translations')) {
    const translationsMainViewModel = new TranslationsMainViewModel();
    loading.addSpinner();
    translationsMainViewModel.fetchLanguages()
        .then(() => translationsMainViewModel.fetchTranslations())
        .then(() => {
            ko.applyBindings(translationsMainViewModel);
            loading.removeSpinner();
        })
}

// Create Page Slug Generator
if (pathName.includes('/admin/pages/create')) {
    const nameInputEl = document.querySelector('.pagenameinput');
    const slugInputEl = document.querySelector('.pagesluginput');
    const aUrlEl = document.querySelector('.aurl');
    const baseurl = document.querySelector('.baseurl').value;

    nameInputEl.addEventListener('keyup', () => {
        const pageName = nameInputEl.value;
        const newSlug = createSlug(pageName);

        aUrlEl.innerHTML = ` ${baseurl}${newSlug}`;
        aUrlEl.setAttribute('href', `${baseurl}${newSlug}`);
        slugInputEl.value = newSlug;
    });

    const createSlug = (text) => {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }
}

// Change Language
const changeLangEl = document.getElementById('langChange');
if (changeLangEl) {
    const currentLang = changeLangEl.value;
    const changeLanguage = (e) => {
        const newLang = changeLangEl.value;
        const url = '/admin/changelang';

        fetch(url, {
            body: JSON.stringify(newLang),
            headers: {
                'content-type': 'application/json'
            },
            credentials: 'include',
            method: 'POST'
        })
            .then(response => response.json())
            .then(newLang => {
                window.location.href = window.location.href.replace(currentLang, newLang);
            });
    }
    changeLangEl.addEventListener('change', changeLanguage);
}

// Toggle Admin box
const toggleAdminBoxEl = document.querySelector('.admin-box__toggle');
const adminBoxWrapperEl = document.querySelector('.admin-box-grid-fixed');

const toggleAdminBox = () => {
    adminBoxWrapperEl.classList.toggle('active');
}

if (toggleAdminBoxEl) toggleAdminBoxEl.addEventListener('click', toggleAdminBox);

// Page Builder draggable Sidebar
$('.admin-box-grid-fixed').draggable({
    axis: 'y',
    containment: 'parent'
});

// Delete Button Confirm Message
const deleteFormElements = document.querySelectorAll('.delete-form');

const submitDeleteForm = function (e) {
    e.target.parentNode.parentNode.submit();
}

const openDeletePopup = function (form) {
    form.preventDefault();
    const button = form.target.querySelector('button');
    button.id = 'error-mode';
    button.querySelector('i').style.display = 'none';

    if (button.querySelectorAll('.error-mode-span').length === 0) {
        const span = document.createElement('span');
        span.classList.add('error-mode-span');
        span.appendChild(document.createTextNode('Are you sure?'));
        button.appendChild(span);

        button.addEventListener('click', submitDeleteForm);

        setTimeout(() => {
            button.id = '';
            button.querySelector('i').style.display = 'block';
            span.parentNode.removeChild(span);
            button.removeEventListener('click', submitDeleteForm);
        }, 3000);
    }
};

deleteFormElements.forEach(deleteFormElement => {
    deleteFormElement.addEventListener('submit', openDeletePopup);
});

// Close Alert on click
const alertEls = document.querySelectorAll('.alert');
if (alertEls) { alertEls.forEach(alertEl => alertEl.querySelector('.alert__close').addEventListener('click', (e) => { alertEl.parentNode.removeChild(alertEl) })) };

// Dashboard Time and Weather Widget
const currentDate = new Date();
const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];
const currentDateString = `${currentDate.getDay() + 1}. ${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
const currentTimeString = `${currentDate.getHours()}:${currentDate.getMinutes()}`;
const dateEl = document.querySelector('.date');
const timeEl = document.querySelector('.time');

if (dateEl) dateEl.innerHTML = currentDateString;
if (timeEl) timeEl.innerHTML = currentTimeString;

// User IMG Popup
if (pathName.includes('/admin/users/') && pathName.includes('edit')) {
    const UserEditViewModel = function () {
        this.mediaPopupVM = ko.observable(new MediaPopupMainViewModel());

        this.openMediaPopup = (element) => {
            this.mediaPopupVM().openMediaPopup();
            const subscription = this.mediaPopupVM().selectedMediaElement.subscribe(() => {
                const path = this.mediaPopupVM().selectedMediaElementPath();
                if (path) {
                    document.querySelector('.user-img-preview').setAttribute('src', path);
                    document.querySelector('#userimg').value = path;
                } else {
                    subscription.dispose();
                }
            });
        }
    }
    ko.applyBindings(new UserEditViewModel());
}