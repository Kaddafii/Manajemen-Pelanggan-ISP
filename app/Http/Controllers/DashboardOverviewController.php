<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\View\View;

class DashboardOverviewController extends Controller
{
    /**
     * Menampilkan metrik dan ringkasan kondisi bisnis pada dashboard Administrator.
     *
     * @return View
     */
    public function displayDashboardMetrics(): View
    {
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('status', 'Aktif')->count();
        $suspendedCustomers = Customer::where('status', 'Suspend')->count();
        $terminatedCustomers = Customer::where('status', 'Putus')->count();
        $unpaidInvoices = Invoice::where('payment_status', 'Belum Bayar')->count();

        // Data grafik jumlah tagihan per bulan sesuai spesifikasi
        $monthlyInvoices = Invoice::selectRaw("billing_period, count(*) as total_count")
            ->groupBy('billing_period')
            ->orderByRaw("MIN(created_at) ASC")
            ->get();

        return view('dashboard.index', [
            'totalCustomers' => $totalCustomers,
            'activeCustomers' => $activeCustomers,
            'suspendedCustomers' => $suspendedCustomers,
            'terminatedCustomers' => $terminatedCustomers,
            'unpaidInvoices' => $unpaidInvoices,
            'monthlyInvoices' => $monthlyInvoices,
        ]);
    }
}
