// Skrip manajemen modal konfirmasi pembayaran tagihan
document.addEventListener('DOMContentLoaded', function () {
    const payButtons = document.querySelectorAll('[data-pay-invoice-id]');
    const backdrop = document.getElementById('paymentModalBackdrop');
    const modal = document.getElementById('paymentConfirmationModal');
    const cancelButton = document.getElementById('cancelPaymentButton');
    const payForm = document.getElementById('payInvoiceForm');
    const periodElement = document.getElementById('payInvoicePeriod');
    const customerElement = document.getElementById('payInvoiceCustomer');
    const amountElement = document.getElementById('payInvoiceAmount');

    if (!modal || !backdrop || !payForm) {
        return;
    }

    function openPaymentModal(invoiceId, customerName, billingPeriod, billingAmount) {
        payForm.setAttribute('action', `/invoices/${invoiceId}/pay`);
        if (customerElement) customerElement.textContent = customerName;
        if (periodElement) periodElement.textContent = billingPeriod;
        if (amountElement) amountElement.textContent = billingAmount;

        backdrop.classList.remove('hidden');
        modal.classList.remove('hidden');
    }

    function closePaymentModal() {
        backdrop.classList.add('hidden');
        modal.classList.add('hidden');
        payForm.setAttribute('action', '');
    }

    payButtons.forEach(button => {
        button.addEventListener('click', function () {
            const invoiceId = this.getAttribute('data-pay-invoice-id');
            const customerName = this.getAttribute('data-pay-invoice-customer');
            const billingPeriod = this.getAttribute('data-pay-invoice-period');
            const billingAmount = this.getAttribute('data-pay-invoice-amount');

            openPaymentModal(invoiceId, customerName, billingPeriod, billingAmount);
        });
    });

    if (cancelButton) {
        cancelButton.addEventListener('click', closePaymentModal);
    }

    backdrop.addEventListener('click', closePaymentModal);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closePaymentModal();
        }
    });
});
