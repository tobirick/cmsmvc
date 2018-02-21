import ko from 'knockout';

import Sidebar from './admin-sidebar';
import Form from './admin-form';
//import {Menu} from './admin-menu';
import MenuListMainViewModel from './VM/MenuListItems/MenuListMainViewModel';

const sidebar = new Sidebar();
const form = new Form();
//const menu = new Menu();

const pathName = window.location.pathname;

if(pathName.includes('/admin/menus/')) {
    ko.applyBindings(new MenuListMainViewModel());
}