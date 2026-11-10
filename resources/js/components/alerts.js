// Handler otomatis untuk menghilangkan alert flash session setelah beberapa saat
document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('[data-auto-dismiss-alert]');

    alerts.forEach(alertElement => {
        const timeoutMs = parseInt(alertElement.getAttribute('data-auto-dismiss-alert'), 10) || 3500;

        function dismissAlert() {
            alertElement.style.transition = 'opacity 0.3s ease, transform 0.3s ease, max-height 0.3s ease';
            alertElement.style.opacity = '0';
            alertElement.style.transform = 'translateY(-6px)';

            setTimeout(() => {
                alertElement.remove();
            }, 300);
        }

        // Timer otomatis untuk menghilangkan alert
        const timer = setTimeout(dismissAlert, timeoutMs);

        // Tombol manual untuk menutup alert
        const closeBtn = alertElement.querySelector('[data-dismiss-button]');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                clearTimeout(timer);
                dismissAlert();
            });
        }
    });
});
