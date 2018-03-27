export default class Sidebar {
    constructor() {
        this.toggleSidebarEl = document.querySelector('.main-content__toggle-sidebar');
        if(this.toggleSidebarEl) {
            document.onreadystatechange = () => {
                const sidebarCurrentStatus = localStorage.getItem('sidebar-closed');
                if(JSON.parse(sidebarCurrentStatus)) {
                    this.toggleSidebarEl.classList.add('open');
                    document.body.classList.add('sidebar-closed');
                }
            };

            this.toggleSidebarEl.addEventListener('click', this.toggleSidebar.bind(this));
        }
    }

    toggleSidebar() {
        this.toggleSidebarEl.classList.toggle('open');
        document.body.classList.toggle('sidebar-closed');
        const currentStatus = document.body.classList.contains('sidebar-closed');
        localStorage.setItem('sidebar-closed', currentStatus);
    }
}