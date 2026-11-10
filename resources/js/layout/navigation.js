// Handler interaktif untuk navigasi layout dan mobile drawer
document.addEventListener('DOMContentLoaded', function () {
    const openBtn = document.getElementById('openMobileMenu');
    const closeBtn = document.getElementById('closeMobileMenu');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const backdrop = document.getElementById('mobileBackdrop');

    function toggleMobileDrawer(shouldOpen) {
        if (!mobileSidebar || !backdrop) return;
        if (shouldOpen) {
            backdrop.classList.remove('hidden');
            mobileSidebar.classList.remove('-translate-x-full');
        } else {
            backdrop.classList.add('hidden');
            mobileSidebar.classList.add('-translate-x-full');
        }
    }

    if (openBtn) openBtn.addEventListener('click', () => toggleMobileDrawer(true));
    if (closeBtn) closeBtn.addEventListener('click', () => toggleMobileDrawer(false));
    if (backdrop) backdrop.addEventListener('click', () => toggleMobileDrawer(false));
});
