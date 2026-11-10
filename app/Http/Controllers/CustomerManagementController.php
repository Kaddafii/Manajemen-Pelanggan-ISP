<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerManagementController extends Controller
{
    /**
     * Menampilkan daftar tabel pelanggan dengan fitur pencarian, sorting, dan pagination.
     *
     * @param Request $request
     * @return View
     */
    public function displayCustomerList(Request $request): View
    {
        $searchKeyword = $request->query('search');
        $sortColumn = $request->query('sort', 'created_at');
        $sortDirection = $request->query('direction', 'desc');

        $customers = Customer::query()
            ->searchByKeyword($searchKeyword)
            ->sortCustomerRecords($sortColumn, $sortDirection)
            ->paginate(10)
            ->withQueryString();

        return view('customers.index', [
            'customers' => $customers,
            'searchKeyword' => $searchKeyword,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * Menampilkan formulir penambahan pelanggan baru.
     *
     * @return View
     */
    public function showCustomerCreationForm(): View
    {
        return view('customers.create');
    }

    /**
     * Menyimpan data pelanggan baru ke database dengan validasi eksplisit.
     *
     * @param CustomerStoreRequest $request
     * @return RedirectResponse
     */
    public function storeNewCustomerRecord(CustomerStoreRequest $request): RedirectResponse
    {
        Customer::create($request->validated());

        return redirect()
            ->route('customers.index')
            ->with('success', 'Data pelanggan baru berhasil disimpan.');
    }

    /**
     * Menampilkan formulir perubahan data pelanggan.
     *
     * @param Customer $customer
     * @return View
     */
    public function showCustomerEditingForm(Customer $customer): View
    {
        return view('customers.edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Memperbarui data pelanggan yang sudah ada di database.
     *
     * @param CustomerUpdateRequest $request
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function updateExistingCustomerRecord(CustomerUpdateRequest $request, Customer $customer): RedirectResponse
    {
        $customer->update($request->validated());

        return redirect()
            ->route('customers.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Menghapus data pelanggan menggunakan mekanisme Soft Delete Laravel.
     * Fitur ini dibatasi secara mutlak hanya untuk Administrator.
     *
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function deleteCustomerWithSoftDelete(Customer $customer): RedirectResponse
    {
        if (! Auth::user()->isAdministratorRole()) {
            abort(403, 'Akses ditolak. Hanya Administrator yang memiliki hak untuk menghapus data pelanggan.');
        }

        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Data pelanggan berhasil dihapus (Soft Delete).');
    }
}
