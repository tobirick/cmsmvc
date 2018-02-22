import ko from 'knockout';

import Sidebar from './admin-sidebar';
import Form from './admin-form';
//import {Menu} from './admin-menu';
import MenuListMainViewModel from './VM/MenuListItems/MenuListMainViewModel';

const sidebar = new Sidebar();
const form = new Form();
//const menu = new Menu();

const pathName = window.location.pathname;

// Edit Menu Page
if(pathName.includes('/admin/menus/')) {
    ko.applyBindings(new MenuListMainViewModel());
}

//Languages
const changeLangEl = document.getElementById('langChange');
if(changeLangEl) {
    const currentLang = changeLangEl.value;
    const changeLanguage = (e) => {
        const newLang = changeLangEl.value;
        const url = '/changelang';

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