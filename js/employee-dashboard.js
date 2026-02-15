

const menuBtn = document.getElementById('menu-btn');
const sidebar = document.getElementById('sidebar');
const main = document.getElementById('main');

// Create overlay
const overlay = document.createElement('div');
overlay.classList.add('sidebar-overlay');
document.body.appendChild(overlay);

menuBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
    main.classList.toggle('sidebar-open');
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
    main.classList.remove('sidebar-open');
});

// Close sidebar on window resize (if desktop)
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        main.classList.remove('sidebar-open');
    }
});
