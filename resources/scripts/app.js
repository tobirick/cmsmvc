import ko from 'knockout';
import { validator } from './validate';
import $ from 'jquery';
import 'knockout-sortable';
import 'knockout-file-bindings';
import 'jquery-ui';
import 'spectrum-colorpicker';

import Sidebar from './admin-sidebar';
import Form from './admin-form';
import MenuListMainViewModel from './VM/MenuListItems/MenuListMainViewModel';
import PagebuilderMainViewModel from './VM/Pagebuilder/PagebuilderMainViewModel';
import MediaMainViewModel from './VM/Media/MediaMainViewModel';
import CreatePagebuilderMainViewModel from './VM/CreatePagebuilder/CreatePagebuilderMainViewModel';
import ThemeMainViewModel from './VM/Theme/ThemeMainViewModel';

import loading from './loading';

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

ko.bindingHandlers.colorPicker = {
   init: function(element, valueAccessor, allBindings) {
     const value = valueAccessor();
     $(element).val(ko.utils.unwrapObservable(value));
     $(element).spectrum({
      preferredFormat: "rgb",
      showAlpha: true,
      showInput: true,
      showButtons: false
     });
     $(element).on('move.spectrum', function(e, color) {
        value(color.toRgbString());
      });
      $(element).on('hide.spectrum', function(e, color) { 
         value(color.toRgbString());
       });
   },
   update: function(element, valueAccessor) {
    const value = valueAccessor();
    ko.bindingHandlers.value.update(element,valueAccessor);
    $(element).val(ko.utils.unwrapObservable(valueAccessor()));
  }
 }


// Edit Menu Page
if(pathName.includes('/admin/menus/') && pathName.includes('edit')) {
    const menuListMainViewModel = new MenuListMainViewModel();
    ko.bindingHandlers.sortable.afterMove = (args) => {
        menuListMainViewModel.updateMenuPositions(args);
    }
    loading.addSpinner();
    menuListMainViewModel.getPages().then(() => {
        menuListMainViewModel.getMenuListItems().then(() => {
            ko.applyBindings(menuListMainViewModel);
            loading.removeSpinner();
        });
    });

}

// Pagebuilder
if(pathName.includes('/admin/pages/') && pathName.includes('edit')) {
    const pagebuilderMainViewModel = new PagebuilderMainViewModel();
    ko.bindingHandlers.sortable.afterMove = (args) => {
        pagebuilderMainViewModel.setPossibleColumns();
    }
    loading.addSpinner();
    pagebuilderMainViewModel.fetchSections().then(() => {
        ko.applyBindings(pagebuilderMainViewModel);
        loading.removeSpinner();
    });
}

// Media
if(pathName.includes('/admin/media')) {
    const mediaMainViewModel = new MediaMainViewModel();
    ko.bindingHandlers.sortable.afterMove = () => {
        mediaMainViewModel.updatePositions();
    }
    loading.addSpinner();
    mediaMainViewModel.fetchMediaElements().then(() => {
        ko.applyBindings(mediaMainViewModel);
        loading.removeSpinner();
    });
}

// Add/Edit Pagebuilder
if(pathName.includes('/admin/pagebuilder/')) {
    const createPagebuilderMainViewModel = new CreatePagebuilderMainViewModel();
    ko.applyBindings(createPagebuilderMainViewModel);
}

// Theme
if(pathName.includes('/admin/themes/') && pathName.includes('edit')) {
   const themeMainViewModel = new ThemeMainViewModel();
    loading.addSpinner();
   themeMainViewModel.fetchThemeSettings().then(() => {
       ko.applyBindings(themeMainViewModel);
       loading.removeSpinner();
   })
}


// Languages
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