// Skrip auto-fill nominal tagihan berdasarkan harga paket pelanggan terpilih
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('invoiceFormContainer');
    const customerInput = document.getElementById('customer_id');
    const amountInput = document.getElementById('billing_amount');

    if (!container || !customerInput || !amountInput) {
        return;
    }

    let customerPriceMap = {};
    try {
        const rawJson = container.getAttribute('data-customer-prices');
        if (rawJson) {
            customerPriceMap = JSON.parse(rawJson);
        }
    } catch (e) {
        customerPriceMap = {};
    }

    function autoFillBillingAmount() {
        const selectedId = customerInput.value;
        if (selectedId && customerPriceMap[selectedId] !== undefined) {
            // Isi otomatis jika kolom nominal masih kosong atau pengguna berganti pelanggan
            const price = parseFloat(customerPriceMap[selectedId]);
            if (!isNaN(price) && (!amountInput.value || amountInput.getAttribute('data-is-autofilled') === 'true')) {
                amountInput.value = Math.round(price);
                amountInput.setAttribute('data-is-autofilled', 'true');
            }
        }
    }

    amountInput.addEventListener('input', function () {
        amountInput.removeAttribute('data-is-autofilled');
    });

    customerInput.addEventListener('change', function () {
        amountInput.setAttribute('data-is-autofilled', 'true');
        autoFillBillingAmount();
    });

    // Inisialisasi awal saat load halaman
    if (!amountInput.value) {
        autoFillBillingAmount();
    }
});
