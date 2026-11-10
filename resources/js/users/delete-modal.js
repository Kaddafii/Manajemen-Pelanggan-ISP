// Skrip modal konfirmasi penghapusan pengguna (User)
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('[data-delete-user-id]');
    const backdrop = document.getElementById('deleteUserModalBackdrop');
    const modal = document.getElementById('deleteUserConfirmationModal');
    const cancelButton = document.getElementById('cancelDeleteUserButton');
    const deleteForm = document.getElementById('deleteUserForm');
    const nameElement = document.getElementById('deleteUserName');
    const emailElement = document.getElementById('deleteUserEmail');

    if (!modal || !backdrop || !deleteForm) {
        return;
    }

    function openDeleteModal(userId, userName, userEmail) {
        deleteForm.setAttribute('action', `/users/${userId}`);
        if (nameElement) nameElement.textContent = userName;
        if (emailElement) emailElement.textContent = userEmail;

        backdrop.classList.remove('hidden');
        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        backdrop.classList.add('hidden');
        modal.classList.add('hidden');
        deleteForm.setAttribute('action', '');
    }

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-delete-user-id');
            const userName = this.getAttribute('data-delete-user-name');
            const userEmail = this.getAttribute('data-delete-user-email');

            openDeleteModal(userId, userName, userEmail);
        });
    });

    if (cancelButton) {
        cancelButton.addEventListener('click', closeDeleteModal);
    }

    backdrop.addEventListener('click', closeDeleteModal);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeDeleteModal();
        }
    });
});
