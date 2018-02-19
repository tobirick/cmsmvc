import ko from 'knockout';

import Sidebar from './admin-sidebar';
import Form from './admin-form';
import {Menu} from './admin-menu';
import MainViewModel from './VM/MainViewModel';

const sidebar = new Sidebar();
const form = new Form();
const menu = new Menu();

ko.applyBindings(MainViewModel);