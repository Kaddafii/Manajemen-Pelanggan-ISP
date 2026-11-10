<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
        $unpaidInvoices = 0; // Akan dihubungkan dengan modul tagihan

        return view('dashboard.index', [
            'totalCustomers' => $totalCustomers,
            'activeCustomers' => $activeCustomers,
            'suspendedCustomers' => $suspendedCustomers,
            'terminatedCustomers' => $terminatedCustomers,
            'unpaidInvoices' => $unpaidInvoices,
        ]);
    }
}
