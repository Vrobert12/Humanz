// validate.js

function validateForm() {
    const email = document.getElementById('mail').value;
    const password = document.getElementById('pass').value;
    const confirmPassword = document.getElementById('pass2').value;
    const phonePrefix = document.querySelector('select[name="tel1"]').value;
    const phoneText = document.getElementById('tel2').value;

    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    const phonePattern = /^\d{7}$/;

    if (!emailPattern.test(email)) {
        showError('mail', 'Please enter a valid email address.');
        return false;
    }

    if (!passwordPattern.test(password)) {
        showError('pass', 'Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, and one number.');
        return false;
    }

    if (password !== confirmPassword) {
        showError('pass2', 'Passwords do not match.');
        return false;
    }

    if (!phonePrefix || phonePrefix === "Number") {
        showError('tel1', 'Please select a valid phone number prefix.');
        return false;
    }

    if (!phonePattern.test(phoneText)) {
        showError('tel2', 'Phone number must be 7 digits long.');
        return false;
    }

    return true;
}

function handleInput(event) {
    const input = event.target;
    let isValid = true;

    if (input.id === 'mail') {
        isValid = validateEmail(input.value);
        if (!isValid) showError(input.id, 'Please enter a valid email address.');
    }

    if (input.id === 'pass') {
        isValid = validatePassword(input.value);
        if (!isValid) showError(input.id, 'Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number and one symbol.');
    }

    if (input.id === 'pass2') {
        const password = document.getElementById('pass').value;
        isValid = input.value === password;
        if (!isValid) showError(input.id, 'Passwords do not match.');
    }

    if (input.id === 'tel2') {
        isValid = validatePhone(input.value);
        if (!isValid) showError(input.id, 'Phone number must be 7 digits long.');
    }

    if (isValid) clearError(input.id);
}

function showError(inputId, message) {
    const warning = document.querySelector('.warning');
    warning.innerHTML = message;
    const input = document.getElementById(inputId) || document.querySelector(`select[name="${inputId}"]`);
    input.classList.add('error');
}

function clearError(inputId) {
    const warning = document.querySelector('.warning');
    warning.innerHTML = '';
    const input = document.getElementById(inputId) || document.querySelector(`select[name="${inputId}"]`);
    input.classList.remove('error');
}

function validateEmail(email) {
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return emailPattern.test(email);
}

function validatePassword(password) {
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    return passwordPattern.test(password);
}

function validatePhone(phone) {
    const phonePattern = /^\d{7}$/;
    return phonePattern.test(phone);
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('.inputok');

    inputs.forEach(input => {
        input.addEventListener('input', handleInput);
    });

    form.addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
});
