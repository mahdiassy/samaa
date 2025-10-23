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
        if (state.element.text == "EN") {
            flag = "gb";
        } else if (state.element.text == "AR") {
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
const mobileMenuToggle = document.getElementById('mobileMenuToggle');
const menu = document.getElementById('menu');
const mobileMenu = document.getElementById('mobileMenu');
const closeMenu = document.getElementById('closeMenu');

console.log('Frontend scripts loaded. Elements found:', {
    menuToggle: !!menuToggle,
    mobileMenuToggle: !!mobileMenuToggle,
    menu: !!menu,
    mobileMenu: !!mobileMenu,
    closeMenu: !!closeMenu
});

// Handle desktop menu toggle
if (menuToggle && menu) {
    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('active');
    });
}

// Handle mobile menu toggle
if (mobileMenuToggle && mobileMenu) {
    mobileMenuToggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        mobileMenu.classList.toggle('hidden');
        
        // Animate burger lines
        const spans = mobileMenuToggle.querySelectorAll('span');
        if (mobileMenu.classList.contains('hidden')) {
            // Menu is closing - reset burger lines
            spans[0].style.transform = 'rotate(0deg)';
            spans[1].style.opacity = '1';
            spans[2].style.transform = 'rotate(0deg)';
        } else {
            // Menu is opening - animate to X
            spans[0].style.transform = 'rotate(45deg) translateY(6px)';
            spans[1].style.opacity = '0';
            spans[2].style.transform = 'rotate(-45deg) translateY(-6px)';
        }
        
        console.log('Mobile menu toggled. Hidden:', mobileMenu.classList.contains('hidden'));
    });
    
    // Add touch events for better mobile support
    mobileMenuToggle.addEventListener('touchstart', (e) => {
        mobileMenuToggle.style.opacity = '0.8';
    });
    
    mobileMenuToggle.addEventListener('touchend', (e) => {
        mobileMenuToggle.style.opacity = '1';
    });
}

if (closeMenu) {
    closeMenu.addEventListener('click', () => {
        if (menu) menu.classList.remove('active');
        if (mobileMenu) mobileMenu.classList.add('hidden');
    });
}

document.addEventListener('click', (event) => {
    const isClickInsideMenu = menu && menu.contains(event.target);
    const isClickInsideToggle = menuToggle && menuToggle.contains(event.target);
    const isClickInsideMobileMenu = mobileMenu && mobileMenu.contains(event.target);
    const isClickInsideMobileToggle = mobileMenuToggle && mobileMenuToggle.contains(event.target);

    if (!isClickInsideMenu && !isClickInsideToggle && menu) {
        menu.classList.remove('active');
    }
    
    if (!isClickInsideMobileMenu && !isClickInsideMobileToggle && mobileMenu) {
        mobileMenu.classList.add('hidden');
        // Reset burger lines when clicking outside
        if (mobileMenuToggle) {
            const spans = mobileMenuToggle.querySelectorAll('span');
            spans[0].style.transform = 'rotate(0deg)';
            spans[1].style.opacity = '1';
            spans[2].style.transform = 'rotate(0deg)';
        }
    }
});

function showPreviousStep() {
    const currentStep = document.querySelector('.form-step.active');
    const prevStep = currentStep.previousElementSibling;
    const stepIndicators = document.querySelectorAll('.step-indicator span');

    if (prevStep && prevStep.classList.contains('form-step')) {
        currentStep.classList.remove('active');
        prevStep.classList.add('active');
    }

    stepIndicators.forEach((step, index) => {
        if (prevStep.classList.contains('personal-info')) {
            step.classList.remove('active-step');
            stepIndicators[0].classList.add('active-step');
        }
    });
}

function validatePersonalInfoStep() {
    const step = document.querySelector('.form-step.personal-info');
    const requiredFields = step.querySelectorAll('input[required], select[required]');

    let isValid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });

    const password = document.getElementById('new_pass');
    const confirmPassword = document.getElementById('confirm_pass');
    const feedback = confirmPassword.nextElementSibling;

    if (password.value !== confirmPassword.value) {
        confirmPassword.classList.add('is-invalid');
        if (feedback) feedback.style.display = 'block';
        isValid = false;
    } else {
        confirmPassword.classList.remove('is-invalid');
        if (feedback) feedback.style.display = 'none';
    }

    return isValid;
}

function validateAndGoToNext() {
    if (validatePersonalInfoStep()) {
        showNextStep();
    }
}

function showNextStep() {
    const currentStep = document.querySelector('.form-step.active');
    const nextStep = currentStep.nextElementSibling;
    const stepIndicators = document.querySelectorAll('.step-indicator span');

    if (nextStep && nextStep.classList.contains('form-step')) {
        currentStep.classList.remove('active');
        nextStep.classList.add('active');
    }

    stepIndicators.forEach((step, index) => {
        if (nextStep.classList.contains('medical-history')) {
            step.classList.remove('active-step');
            stepIndicators[1].classList.add('active-step');
        }
    });
}
/*document.getElementById("increment").addEventListener("click", function() {
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
});*/

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
