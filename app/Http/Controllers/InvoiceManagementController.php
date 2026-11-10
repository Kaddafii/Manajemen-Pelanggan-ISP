<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceManagementController extends Controller
{
    /**
     * Menampilkan daftar tagihan pelanggan dengan dukungan pencarian, filter status, dan pagination.
     *
     * @param Request $request
     * @return View
     */
    public function displayInvoiceList(Request $request): View
    {
        $searchKeyword = $request->query('search');
        $paymentStatusFilter = $request->query('status');
        $sortColumn = $request->query('sort', 'created_at');
        $sortDirection = $request->query('direction', 'desc');

        $invoices = Invoice::with(['customer'])
            ->searchInvoicesByKeyword($searchKeyword)
            ->filterByPaymentStatus($paymentStatusFilter)
            ->sortInvoiceRecords($sortColumn, $sortDirection)
            ->paginate(10)
            ->withQueryString();

        return view('invoices.index', [
            'invoices' => $invoices,
            'searchKeyword' => $searchKeyword,
            'paymentStatusFilter' => $paymentStatusFilter,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * Menampilkan formulir pembuatan data tagihan baru untuk pelanggan.
     *
     * @param Request $request
     * @return View
     */
    public function showInvoiceCreationForm(Request $request): View
    {
        // Ambil daftar pelanggan yang tidak terhapus untuk pilihan dropdown
        $customers = Customer::orderBy('name', 'asc')->get([
            'id', 
            'name', 
            'phone_number', 
            'internet_package', 
            'package_price'
        ]);

        $selectedCustomerId = $request->query('customer_id');

        return view('invoices.create', [
            'customers' => $customers,
            'selectedCustomerId' => $selectedCustomerId,
        ]);
    }

    /**
     * Menyimpan data tagihan baru ke database setelah divalidasi.
     *
     * @param InvoiceStoreRequest $request
     * @return RedirectResponse
     */
    public function storeNewInvoiceRecord(InvoiceStoreRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $paymentDate = $validatedData['payment_status'] === 'Lunas' ? now() : null;

        Invoice::create([
            'customer_id' => $validatedData['customer_id'],
            'billing_period' => $validatedData['billing_period'],
            'billing_amount' => $validatedData['billing_amount'],
            'payment_status' => $validatedData['payment_status'],
            'payment_date' => $paymentDate,
        ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Data tagihan baru berhasil disimpan ke sistem.');
    }

    /**
     * Melakukan proses pembayaran tagihan: mengubah status menjadi Lunas dan mencatat waktu pembayaran saat ini.
     *
     * @param Invoice $invoice
     * @return RedirectResponse
     */
    public function markInvoiceAsPaid(Invoice $invoice): RedirectResponse
    {
        if ($invoice->isPaidStatus()) {
            return redirect()->route('invoices.index')
                ->with('error', 'Tagihan ini sudah berstatus Lunas sebelumnya.');
        }

        $invoice->markInvoiceAsPaidWithCurrentTimestamp();

        return redirect()->route('invoices.index')
            ->with('success', 'Tagihan periode ' . $invoice->billing_period . ' untuk pelanggan ' . $invoice->customer->name . ' berhasil dibayar (Lunas).');
    }
}
