// Handler modal konfirmasi hapus data pelanggan (Soft Delete)
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteConfirmationModal');
    const deleteBackdrop = document.getElementById('deleteModalBackdrop');
    const deleteForm = document.getElementById('deleteCustomerForm');
    const customerNameDisplay = document.getElementById('deleteCustomerName');
    const cancelDeleteButton = document.getElementById('cancelDeleteButton');
    const deleteTriggerButtons = document.querySelectorAll('[data-delete-customer-id]');

    function openDeleteModal(customerId, customerName) {
        if (!deleteModal || !deleteForm || !deleteBackdrop) return;

        deleteForm.action = `/customers/${customerId}`;
        if (customerNameDisplay) {
            customerNameDisplay.textContent = customerName;
        }

        deleteBackdrop.classList.remove('hidden');
        deleteModal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        if (!deleteModal || !deleteBackdrop) return;

        deleteBackdrop.classList.add('hidden');
        deleteModal.classList.add('hidden');
    }

    deleteTriggerButtons.forEach(button => {
        button.addEventListener('click', function () {
            const customerId = this.getAttribute('data-delete-customer-id');
            const customerName = this.getAttribute('data-delete-customer-name');
            openDeleteModal(customerId, customerName);
        });
    });

    if (cancelDeleteButton) {
        cancelDeleteButton.addEventListener('click', closeDeleteModal);
    }

    if (deleteBackdrop) {
        deleteBackdrop.addEventListener('click', closeDeleteModal);
    }
});
