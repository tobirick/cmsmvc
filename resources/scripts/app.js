import Sidebar from './admin-sidebar';
import Form from './admin-form';
import Menu from './admin-menu';

const updateCSRF = (newCsrfToken) => {
    const csrfElements = document.querySelectorAll('input[name="csrf_token"]');
    csrfElements.forEach(csrfElement => {
        csrfElement.value = newCsrfToken;
    });
};

const sidebar = new Sidebar();
const form = new Form();
const menu = new Menu();