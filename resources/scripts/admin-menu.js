export default class Menu {
    constructor() {
        this.addMenuItemFormEl = document.getElementById('add-menu-item');
        this.deleteMenuItemFormEls = document.querySelectorAll('#delete-menu-item');
        this.updateMenuItemFormEl = document.getElementById('update-menu-item');
        this.menuListEl = document.getElementById('menu-list');

        this.setEventListeners();
    }

    setEventListeners() {
        this.addMenuItemFormEl.addEventListener('submit', function (e) {
            this.add(e);
        }.bind(this), false);

        this.deleteMenuItemFormEls.forEach(deleteMenuItemFormEl => {
            deleteMenuItemFormEl.addEventListener('submit', function (e) {
                this.delete(e);
            }.bind(this), false);
        });

        this.updateMenuItemFormEl.addEventListener('submit', function (e) {
            this.update(e);
        }.bind(this), false);
    }

    loadMenuList() {
        const url = window.location.href + '#menu-list';
        fetch(url, {
            credentials: 'include'
        })
            .then(response => response.text())
            .then(data => {
                const html = document.createElement('html');
                html.innerHTML = data;
                const menuList = html.querySelector('#menu-list').innerHTML;
                this.menuListEl.innerHTML = menuList;
            });
    }

    add(e) {
        e.preventDefault();
        const data = {
            menuitem: {
                name: document.querySelector('input[name="menuitem[name]"]').value,
                page: document.querySelector('select[name="menuitem[page]"]').value,
            },
            csrf_token: document.querySelector('input[name="csrf_token"]').value
        };
        const menuid = document.querySelector('input[name="menu_id"]').value;

        const url = `/admin/menus/${menuid}/menuitems`;

        fetch(url, {
            body: JSON.stringify(data),
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
        const data = {
            '_METHOD': 'DELETE',
            csrf_token: document.querySelector('input[name="csrf_token"]').value
        };

        fetch(e.srcElement.action, {
            body: JSON.stringify(data),
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
    }
}