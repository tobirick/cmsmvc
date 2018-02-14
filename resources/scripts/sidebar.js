export class SidebarToggle {
    constructor() {
        const toggleSidebarEl = document.querySelector('.main-content__toggle-sidebar');
        
        document.onreadystatechange = () => {
            const sidebarCurrentStatus = localStorage.getItem('sidebar-closed');
            if(JSON.parse(sidebarCurrentStatus)) {
                toggleSidebarEl.classList.add('open');
                document.body.classList.add('sidebar-closed');
            }
        };
        
        const toggleSidebar = () => {
            toggleSidebarEl.classList.toggle('open');
            document.body.classList.toggle('sidebar-closed');
            const currentStatus = document.body.classList.contains('sidebar-closed') ? true : false;
            localStorage.setItem('sidebar-closed', currentStatus);
        };
        
        toggleSidebarEl.addEventListener('click', toggleSidebar);
    }
}