const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const nameInput = form.querySelector('input[name="name"]');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function isNameValid(name) {
    const nameRegex = /^[A-Za-z\s]{1,20}$/; // Allows letters and spaces, up to 20 characters
    return nameRegex.test(name);
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

function validateEmail() {
    setTimeout(function () {
        markValidation(emailInput, isEmail(emailInput.value));
    }, 1000);
}

function validateName() {
    setTimeout(function () {
        markValidation(nameInput, isNameValid(nameInput.value));
    }, 500);
}

emailInput.addEventListener('keyup', validateEmail);
nameInput.addEventListener('keyup', validateName);
