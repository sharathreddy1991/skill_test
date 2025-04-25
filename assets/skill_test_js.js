document.addEventListener('DOMContentLoaded', function() {
    const phoneNumberField = document.querySelector('input[name="phone_number"]');
    phoneNumberField.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    document.querySelectorAll('input, select').forEach((field) => {
        field.addEventListener('blur', function () {
            let errorElement = this.nextElementSibling;
            if (!errorElement || !errorElement.classList.contains('error-message')) {
                errorElement = document.createElement('span');
                errorElement.className = 'error-message';
                errorElement.style.color = 'red';
                errorElement.style.fontSize = '12px';
                this.parentNode.appendChild(errorElement);
            }

            if (!this.checkValidity()) {
                errorElement.textContent = this.validationMessage;
            } else {
                errorElement.textContent = '';
            }
        });

        field.addEventListener('invalid', function () {
            const errorElement = this.nextElementSibling;
            if (errorElement && errorElement.classList.contains('error-message')) {
                errorElement.textContent = 'Please fill out this field correctly.';
            }
        });

        field.addEventListener('input', function () {
            const errorElement = this.nextElementSibling;
            if (errorElement && errorElement.classList.contains('error-message')) {
                errorElement.textContent = '';
            }
        });
    });
});