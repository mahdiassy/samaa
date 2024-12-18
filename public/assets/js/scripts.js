document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');

    if (!savedTheme) {
        showPopup();
    } else {
        applyTheme(savedTheme);
    }
});

function applyTheme(theme) {
    const themeStyle = document.getElementById('theme-style');
    const kidsStyle = document.getElementById('kids-style');

    if (theme === 'kids') {
        themeStyle.disabled = true;
        kidsStyle.disabled = false;
        document.title = "SAMAA FOR KIDS";
    } else {
        themeStyle.disabled = false;
        kidsStyle.disabled = true;
        document.title = "SAMAA";
    }

    localStorage.setItem('theme', theme);
}

function showPopup() {
    document.getElementById('theme-popup').classList.add('active');
    document.getElementById('overlay').classList.add('active');
}

function closePopup() {
    document.getElementById('theme-popup').classList.remove('active');
    document.getElementById('overlay').classList.remove('active');
}

document.getElementById('default-theme-btn').addEventListener('click', () => {
    applyTheme('default');
    closePopup();
});

document.getElementById('kids-theme-btn').addEventListener('click', () => {
    applyTheme('kids');
    closePopup();
});
