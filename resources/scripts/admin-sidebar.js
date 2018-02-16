export default class Sidebar {
    constructor() {
        this.toggleSidebarEl = document.querySelector('.main-content__toggle-sidebar');
        document.onreadystatechange = () => {
            const sidebarCurrentStatus = localStorage.getItem('sidebar-closed');
            if(JSON.parse(sidebarCurrentStatus)) {
                this.toggleSidebarEl.classList.add('open');
                document.body.classList.add('sidebar-closed');
            }
        };

        if(this.toggleSidebarEl) this.toggleSidebarEl.addEventListener('click', this.toggleSidebar.bind(this));
    }

    toggleSidebar() {
        this.toggleSidebarEl.classList.toggle('open');
        document.body.classList.toggle('sidebar-closed');
        const currentStatus = document.body.classList.contains('sidebar-closed') ? true : false;
        localStorage.setItem('sidebar-closed', currentStatus);
    }
}