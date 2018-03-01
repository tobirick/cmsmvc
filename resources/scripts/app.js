import ko from 'knockout';
import { validator } from './validate';
import $ from 'jquery';
import 'jquery-ui';

import Sidebar from './admin-sidebar';
import Form from './admin-form';
import MenuListMainViewModel from './VM/MenuListItems/MenuListMainViewModel';
import PagebuilderMainViewModel from './VM/Pagebuilder/PagebuilderMainViewModel';

validator.init('#validate-form');
validator.addBasicRules();
const sidebar = new Sidebar();
const form = new Form();

const pathName = window.location.pathname;

// Edit Menu Page
if(pathName.includes('/admin/menus/')) {
    const menuListMainViewModel = new MenuListMainViewModel();
    ko.bindingHandlers.sortable.afterMove = (args) => {
        menuListMainViewModel.updateMenuPositions(args);
    }
    ko.applyBindings(menuListMainViewModel);
}

// Pagebuilder
if(pathName.includes('/admin/pages/')) {
    const pagebuilderMainViewModel = new PagebuilderMainViewModel();
    ko.bindingHandlers.sortable.afterMove = (args) => {
        console.log(ko.toJS(pagebuilderMainViewModel.sections));
        pagebuilderMainViewModel.generateHTML();
        pagebuilderMainViewModel.setPossibleColumns();
    }
    ko.applyBindings(pagebuilderMainViewModel);
}


//Languages
const changeLangEl = document.getElementById('langChange');
if(changeLangEl) {
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
                /*
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
                */
            });
    }
    changeLangEl.addEventListener('change', changeLanguage);
}

// Toggle Admin box
const toggleAdminBoxEl = document.querySelector('.admin-box__toggle');
const adminBoxWrapperEl = document.querySelector('.admin-draggable-cols-wrapper');

const toggleAdminBox = () => {
    adminBoxWrapperEl.classList.toggle('active');
}

const closeAdminBox = (e) => {
    if(e.target != adminBoxWrapperEl) {
        console.log('close');
        adminBoxWrapperEl.classList.remove('active');
    }
}

toggleAdminBoxEl.addEventListener('click', toggleAdminBox);
//document.querySelector('body').addEventListener('click', closeAdminBox)

$( ".admin-draggable-cols-wrapper" ).draggable({ 
    axis: "y",
    containment: 'parent'
});

