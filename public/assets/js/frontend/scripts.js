$(document).ready(function() {
    $('#language-select').select2({
        templateResult: formatState,
        templateSelection: formatState,
        minimumResultsForSearch: Infinity,
        width: '100%',
    });
    function formatState(state) {
        if (!state.id) { return state.text; }
        var flag;
        if (state.element.text == "English") {
            flag = "gb";
        } else if (state.element.text == "Arabic") {
            flag = "sa";
        } else {
            flag = "fr";
        }

        let $state = $(
            `<span><img src="https://cdn.jsdelivr.net/npm/svg-country-flags@1.2.10/svg/${flag}.svg"
                class="flag" width="23px" style="margin-right: 8px;" /> ${state.text}</span>`
        );
        return $state;
    }
});

document.addEventListener('scroll', function () {
    const nav = document.querySelector('nav');
    if (window.scrollY > 50) {
        nav.classList.add('scrolled');
    } else {
        nav.classList.remove('scrolled');
    }
});

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

function showNextStep() {
    // Get the current active step and the next step
    const currentStep = document.querySelector('.form-step.active');
    const nextStep = currentStep.nextElementSibling;
    const stepIndicators = document.querySelectorAll('.step-indicator span');

    // If there is a next step, toggle active classes
    if (nextStep && nextStep.classList.contains('form-step')) {
        currentStep.classList.remove('active');
        nextStep.classList.add('active');
    }

    // Update step indicator
    stepIndicators.forEach((step, index) => {
        if (nextStep.classList.contains('medical-history')) {
            step.classList.remove('active-step');
            stepIndicators[1].classList.add('active-step');
        }
    });
}
document.getElementById("increment").addEventListener("click", function() {
    let input = document.getElementById("height");
    let currentValue = parseInt(input.value) || 0;
    input.value = currentValue + 1;
});

document.getElementById("decrement").addEventListener("click", function() {
    let input = document.getElementById("height");
    let currentValue = parseInt(input.value) || 0;
    if (currentValue > 0) {
        input.value = currentValue - 1;
    }
});

document.getElementById("incrementWeight").addEventListener("click", function() {
    let inputWeight = document.getElementById("weight");
    let currentValueWeight = parseInt(inputWeight.value) || 0;
    inputWeight.value = currentValueWeight + 1;
});

document.getElementById("decrementWeight").addEventListener("click", function() {
    let inputWeight = document.getElementById("weight");
    let currentValueWeight = parseInt(inputWeight.value) || 0;
    if (currentValueWeight > 0) {
        inputWeight.value = currentValueWeight - 1;
    }
});

function updateProfilePicture(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profileImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
