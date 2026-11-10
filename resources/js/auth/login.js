// Handler interaktif untuk halaman Login
document.addEventListener('DOMContentLoaded', function () {
    const togglePasswordButton = document.getElementById('togglePasswordButton');
    const passwordInput = document.getElementById('password');
    const togglePasswordIcon = document.getElementById('togglePasswordIcon');

    if (togglePasswordButton && passwordInput && togglePasswordIcon) {
        togglePasswordButton.addEventListener('click', function () {
            const isPasswordType = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPasswordType ? 'text' : 'password');
            togglePasswordIcon.className = isPasswordType ? 'bi bi-eye-slash text-base' : 'bi bi-eye text-base';
        });
    }

    const demoButtons = document.querySelectorAll('[data-demo-email]');
    demoButtons.forEach(button => {
        button.addEventListener('click', function () {
            const email = this.getAttribute('data-demo-email');
            const password = this.getAttribute('data-demo-password');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            if (emailInput && passwordInput) {
                emailInput.value = email;
                passwordInput.value = password;
                emailInput.focus();
            }
        });
    });
});
