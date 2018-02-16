import {updateCSRF} from './helpers';

export default class Menu {
    constructor() {
        this.addMenuItemFormEl = document.getElementById('add-menu-item');
        this.menuListEl = document.getElementById('menu-list');

        this.addMenuItemFormEl.addEventListener('submit', function (e) {
            this.add(e);
        }.bind(this), false);
        this.loadElements();
    }

    loadElements() {
        this.deleteMenuItemFormEls = document.querySelectorAll('#delete-menu-item');
        this.updateMenuItemFormEls = document.querySelectorAll('#update-menu-item');

        this.setEventListeners();
    }

    setEventListeners() {
        this.deleteMenuItemFormEls.forEach(deleteMenuItemFormEl => {
            deleteMenuItemFormEl.addEventListener('submit', function (e) {
                this.delete(e);
            }.bind(this), false);
        });

        this.updateMenuItemFormEls.forEach(updateMenuItemFormEl => {
            updateMenuItemFormEl.addEventListener('submit', function (e) {
                this.update(e);
            }.bind(this), false);
        });
    }

    loadMenuList(newCsrfToken) {
        const url = window.location.href;
        fetch(url, {
            credentials: 'include'
        })
            .then(response => response.text())
            .then(data => {
                const html = document.createElement('html');
                html.innerHTML = data;
                const menuList = html.querySelector('#menu-list').innerHTML;
                this.menuListEl.innerHTML = menuList;
                this.loadElements();
                updateCSRF(html.querySelector('#csrf').value);
            });
    }

    add(e) {
        e.preventDefault();
        const formData = {
            menuitem: {
                name: document.querySelector('#' + e.target.id + ' input[name="menuitem[name]"]').value,
                page: document.querySelector('#' + e.target.id + ' select[name="menuitem[page]"]').value,
            },
            csrf_token: document.querySelector('input[name="csrf_token"]').value
        };

        fetch(e.srcElement.action, {
            body: JSON.stringify(formData),
            headers: {
                'content-type': 'application/json'
            },
            credentials: 'include',
            method: 'POST'
        })
            .then(data => this.loadMenuList());
    }

    delete(e) {
        e.preventDefault();
        const formData = {
            '_METHOD': 'DELETE',
            csrf_token: document.querySelector('input[name="csrf_token"]').value
        };

        fetch(e.srcElement.action, {
            body: JSON.stringify(formData),
            headers: {
                'content-type': 'application/json'
            },
            credentials: 'include',
            method: 'POST'
        })
            .then(data => this.loadMenuList());
    }

    update(e) {
        e.preventDefault();
        const formData = {
            menuitem: {
                name: e.target.elements["menuitem[name]"].value,
                page: e.target.elements["menuitem[page]"].value,
            },
            '_METHOD': 'PUT',
            csrf_token: document.querySelector('input[name="csrf_token"]').value
        };

        fetch(e.srcElement.action, {
            body: JSON.stringify(formData),
            headers: {
                'content-type': 'application/json'
            },
            credentials: 'include',
            method: 'POST'
        })
            .then(data => this.loadMenuList());
    }
}