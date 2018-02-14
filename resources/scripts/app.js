const toggleSidebarEl = document.querySelector('.main-content__toggle-sidebar');

toggleSidebarEl.addEventListener('click', () => {
    toggleSidebarEl.classList.toggle('open');
    document.body.classList.toggle('sidebar-open');
});