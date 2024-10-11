const menuToggle = document.getElementById('menuToggle');
const menu = document.getElementById('menu');
const closeMenu = document.getElementById('closeMenu');

menuToggle.addEventListener('click', () => {
    menu.classList.toggle('active');
});

closeMenu.addEventListener('click', () => {
    menu.classList.remove('active');
});

document.addEventListener('click', (event) => {
    const isClickInsideMenu = menu.contains(event.target);
    const isClickInsideToggle = menuToggle.contains(event.target);

    if (!isClickInsideMenu && !isClickInsideToggle) {
        menu.classList.remove('active');
    }
});
