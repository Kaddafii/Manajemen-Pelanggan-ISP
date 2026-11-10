// Skrip toggle visibilitas password pada formulir pengguna
document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('[data-toggle-password]');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const inputId = this.getAttribute('data-toggle-password');
            const inputField = document.getElementById(inputId);
            const icon = this.querySelector('i');

            if (!inputField || !icon) return;

            if (inputField.type === 'password') {
                inputField.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                inputField.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
});
