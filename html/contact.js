document.addEventListener('DOMContentLoaded', function () {
    const messageForm = document.getElementById('messageForm');
    const contactForm = document.getElementById('contactForm');

    messageForm.addEventListener('submit', function (event) {
        if (!validateForm(messageForm)) {
            event.preventDefault();
        }
    });

    contactForm.addEventListener('submit', function (event) {
        if (!validateForm(contactForm)) {
            event.preventDefault();
        }
    });

    function validateForm(form) {
        let isValid = true;
        const inputs = form.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });
        return isValid;
    }
});