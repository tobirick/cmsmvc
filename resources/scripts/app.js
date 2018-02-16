import Sidebar from './admin-sidebar';
import Form from './admin-form';
import Menu from './admin-menu';

const sidebar = new Sidebar();
const form = new Form();
const menu = new Menu();

const updateCSRF = (newCsrfToken) => {
    const csrfElements = document.querySelectorAll('input[name="csrf_token"]');
    
    csrfElements.forEach(csrfElement => {
        csrfElement.value = newCsrfToken;
    });
};