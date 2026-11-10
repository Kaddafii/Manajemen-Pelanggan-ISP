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
});
