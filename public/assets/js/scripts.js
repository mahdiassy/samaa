document.addEventListener('DOMContentLoaded', function () {
    const therapeuticAreaSelect = document.getElementById('therapeutic_area');
    const diseaseSelect = document.getElementById('disease');

    therapeuticAreaSelect.addEventListener('change', function () {
        const therapeuticAreaId = this.value;

        diseaseSelect.innerHTML = `<option value="" disabled selected>${selectDiseaseText}</option>`;

        diseaseSelect.disabled = true;

        if (therapeuticAreaId) {
            fetch(`/getDiseases/${therapeuticAreaId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.diseases) {
                        data.diseases.forEach(disease => {
                            const option = document.createElement('option');
                            option.value = disease.id;
                            option.textContent = disease.name;
                            diseaseSelect.appendChild(option);
                        });
                        diseaseSelect.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error fetching diseases:', error);
                });
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
document.getElementById('therapeutic_areas_select').addEventListener('change', function () {
    const selectedValue = this.value;
    const inputWrapper = document.getElementById('medication_input_wrapper');

    if (selectedValue === '2') {
        inputWrapper.style.display = 'block';
    } else {
        inputWrapper.style.display = 'none';
    }
});
$(document).ready(function() {
    $('.diseases-select').select2({
        placeholder: "{{ __('site.Select one or more diseases') }}",
        /*allowClear: true,*/
        width: '100%'
    });
});
