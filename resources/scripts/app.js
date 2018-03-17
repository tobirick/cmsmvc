import ko from 'knockout';
import { validator } from './validate';
import $ from 'jquery';
import 'jquery-ui';

import Sidebar from './admin-sidebar';
import Form from './admin-form';
import MenuListMainViewModel from './VM/MenuListItems/MenuListMainViewModel';
import PagebuilderMainViewModel from './VM/Pagebuilder/PagebuilderMainViewModel';
import MediaMainViewModel from './VM/Media/MediaMainViewModel';

validator.init('#validate-form');
validator.addBasicRules();
const sidebar = new Sidebar();
const form = new Form();

const pathName = window.location.pathname;

// Knockout //
ko.bindingHandlers.tabs = {
    init: function (element, valueAccessor, allBindingsAccessor, viewModel) {
        $('.popup__content').find('.tab-content').css('display', 'none');
        $('.popup__content').find('.tab-content:first-child').css('display', 'block');

        $(element).find('li').on('click', function () {
            const section = $(this).data('tabsection');
            $(element).find('li').removeClass('active');
            $(this).addClass('active');
            $('.popup__content').find('.tab-content').css('display', 'none');
            $('.popup__content').find('#' + section).css('display', 'block');
        });
    }
};

// Edit Menu Page
if(pathName.includes('/admin/menus/') && pathName.includes('edit')) {
    const menuListMainViewModel = new MenuListMainViewModel();
    ko.bindingHandlers.sortable.afterMove = (args) => {
        menuListMainViewModel.updateMenuPositions(args);
    }
    ko.applyBindings(menuListMainViewModel);
}

// Pagebuilder
if(pathName.includes('/admin/pages/') && pathName.includes('edit')) {
    const pagebuilderMainViewModel = new PagebuilderMainViewModel();
    ko.bindingHandlers.sortable.afterMove = (args) => {
        console.log(ko.toJS(pagebuilderMainViewModel.sections));
        pagebuilderMainViewModel.generateHTML();
        pagebuilderMainViewModel.setPossibleColumns();
    }
    ko.applyBindings(pagebuilderMainViewModel);
}

// Media
if(pathName.includes('/admin/media')) {
    const mediaMainViewModel = new MediaMainViewModel();
    ko.applyBindings(mediaMainViewModel);
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
const adminBoxWrapperEl = document.querySelector('.admin-box-grid-fixed');

const toggleAdminBox = () => {
    adminBoxWrapperEl.classList.toggle('active');
}

if (toggleAdminBoxEl) toggleAdminBoxEl.addEventListener('click', toggleAdminBox);

$(".admin-box-grid-fixed").draggable({ 
    axis: "y",
    containment: 'parent'
});

