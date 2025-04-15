document.addEventListener('DOMContentLoaded', function () {
    const doctorSearch = document.getElementById('doctor-search');
    const box = document.getElementById('search-suggestions');
    let input = document.querySelector('.search-bar input[type="text"]') || document.querySelector('.search-container input[type="text"]');

    if (!doctorSearch || !box || !input) {
        console.warn('Doctor search input or suggestion box not found in the DOM.');
        return;
    }

    doctorSearch.addEventListener('input', function () {
        const query = this.value.trim();

        if (query.length === 0) {
            box.style.display = 'none';
            box.innerHTML = '';
            input.classList.remove('rounded-top');
            return;
        }

        if (query.length < 2) {
            box.style.display = 'none';
            return;
        }

        fetch(route('doctor.search', { q: query }))
            .then(res => res.json())
            .then(data => {
                box.innerHTML = '';

                if (data.length === 0) {
                    box.innerHTML = `<div style="padding: 8px;">${noResult}</div>`;
                    input.classList.add('rounded-top');
                } else {
                    input.classList.add('rounded-top');

                    data.forEach((doctor, index) => {
                        const div = document.createElement('div');
                        div.textContent = doctor.first_name;
                        div.style.padding = '5px';
                        div.style.borderBottom = '1px solid #ccc';
                        div.style.cursor = 'pointer';
                        div.style.transition = 'background-color 0.2s ease';

                        div.addEventListener('mouseenter', () => {
                            div.style.backgroundColor = '#e4e3e3';
                            div.style.borderRadius = '20px';
                        });

                        div.addEventListener('mouseleave', () => {
                            div.style.backgroundColor = '';
                            div.style.borderRadius = '';
                        });

                        if (index === data.length - 1) {
                            div.style.borderBottom = 'none';
                        }

                        div.addEventListener('click', () => {
                            window.location.href = route('doctor.show', { doctor: doctor.id });
                        });
                        box.appendChild(div);
                    });
                }

                box.style.display = 'block';
            })
            .catch(err => {
                console.error('Error fetching doctors:', err);
            });
    });

    document.addEventListener('click', function (e) {
        if (!doctorSearch.contains(e.target) && !box.contains(e.target)) {
            box.style.display = 'none';
            box.innerHTML = '';
            input.classList.remove('rounded-top');
        }
    });
});

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
        document.title = `${samaaKidsTitle}`;
    } else {
        themeStyle.disabled = false;
        kidsStyle.disabled = true;
        document.title = `${samaaTitle}`;
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
document.addEventListener('DOMContentLoaded', function () {
    const therapeuticSelect = document.getElementById('therapeutic_areas_select');
    const inputWrapper = document.getElementById('medication_input_wrapper');

    if (!therapeuticSelect || !inputWrapper) {
        console.warn('therapeutic_areas_select or medication_input_wrapper not found.');
        return;
    }

    therapeuticSelect.addEventListener('change', function () {
        const selectedValue = this.value;

        if (selectedValue === '2') {
            inputWrapper.style.display = 'block';
        } else {
            inputWrapper.style.display = 'none';
        }
    });
});

$(document).ready(function() {
    $('.diseases-select').select2({
        placeholder: "{{ __('site.Select one or more diseases') }}",
        /*allowClear: true,*/
        width: '100%'
    });
});
