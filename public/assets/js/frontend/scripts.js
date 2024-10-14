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
    let currentValue = parseInt(input.value) || 0; // Defaults to 0 if input is empty or invalid
    input.value = currentValue + 1;
});

document.getElementById("decrement").addEventListener("click", function() {
    let input = document.getElementById("height");
    let currentValue = parseInt(input.value) || 0; // Defaults to 0 if input is empty or invalid
    if (currentValue > 0) {
        input.value = currentValue - 1;
    }
});

document.getElementById("incrementWeight").addEventListener("click", function() {
    let inputWeight = document.getElementById("weight");
    let currentValueWeight = parseInt(inputWeight.value) || 0; // Defaults to 0 if input is empty or invalid
    inputWeight.value = currentValueWeight + 1;
});

document.getElementById("decrementWeight").addEventListener("click", function() {
    let inputWeight = document.getElementById("weight");
    let currentValueWeight = parseInt(inputWeight.value) || 0; // Defaults to 0 if input is empty or invalid
    if (currentValueWeight > 0) {
        inputWeight.value = currentValueWeight - 1;
    }
});

