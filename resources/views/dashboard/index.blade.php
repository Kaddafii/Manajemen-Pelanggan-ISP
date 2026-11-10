<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>
    <x-slot:header>Dashboard</x-slot:header>

    <div class="space-y-6">
        <!-- 5 Kartu Statistik Sesuai Spesifikasi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- 1. Total Pelanggan -->
            <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl p-4 shadow-[4px_4px_0px_#18181B] flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#71717A]">Total Pelanggan</span>
                    <div class="w-8 h-8 rounded-lg bg-[#FAF8F5] border-2 border-[#18181B] flex items-center justify-center text-[#18181B]">
                        <i class="bi bi-people-fill text-sm"></i>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-[#18181B]">
                    {{ $totalCustomers ?? 0 }}
                </div>
            </div>

            <!-- 2. Total Pelanggan Aktif -->
            <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl p-4 shadow-[4px_4px_0px_#18181B] flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#047857]">Pelanggan Aktif</span>
                    <div class="w-8 h-8 rounded-lg bg-[#ECFDF5] border-2 border-[#18181B] flex items-center justify-center text-[#047857]">
                        <i class="bi bi-check-circle-fill text-sm"></i>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-[#047857]">
                    {{ $activeCustomers ?? 0 }}
                </div>
            </div>

            <!-- 3. Total Pelanggan Suspend -->
            <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl p-4 shadow-[4px_4px_0px_#18181B] flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#B45309]">Pelanggan Suspend</span>
                    <div class="w-8 h-8 rounded-lg bg-[#FFFBEB] border-2 border-[#18181B] flex items-center justify-center text-[#B45309]">
                        <i class="bi bi-pause-circle-fill text-sm"></i>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-[#B45309]">
                    {{ $suspendedCustomers ?? 0 }}
                </div>
            </div>

            <!-- 4. Total Pelanggan Putus -->
            <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl p-4 shadow-[4px_4px_0px_#18181B] flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#B91C1C]">Pelanggan Putus</span>
                    <div class="w-8 h-8 rounded-lg bg-[#FEF2F2] border-2 border-[#18181B] flex items-center justify-center text-[#B91C1C]">
                        <i class="bi bi-x-circle-fill text-sm"></i>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-[#B91C1C]">
                    {{ $terminatedCustomers ?? 0 }}
                </div>
            </div>

            <!-- 5. Total Tagihan Belum Bayar -->
            <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl p-4 shadow-[4px_4px_0px_#18181B] flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#DC2626]">Tagihan Belum Bayar</span>
                    <div class="w-8 h-8 rounded-lg bg-[#FEF2F2] border-2 border-[#18181B] flex items-center justify-center text-[#DC2626]">
                        <i class="bi bi-receipt-cutoff text-sm"></i>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-[#DC2626]">
                    {{ $unpaidInvoices ?? 0 }}
                </div>
            </div>
        </div>

        <!-- Kartu Grafik Tagihan Per Bulan -->
        <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl p-6 shadow-[6px_6px_0px_#18181B]">
            <div class="flex items-center justify-between mb-4 pb-3 border-b-2 border-[#18181B]">
                <h3 class="text-sm font-extrabold uppercase tracking-tight text-[#18181B]">
                    Grafik Jumlah Tagihan Per Bulan
                </h3>
            </div>

            <!-- Area Tampilan Grafik / Empty State Data -->
            <div class="h-64 flex flex-col items-center justify-center bg-[#FAF8F5] border-2 border-dashed border-[#18181B] rounded-xl p-6 text-center">
                <div class="w-12 h-12 rounded-xl bg-[#FFFFFF] border-2 border-[#18181B] flex items-center justify-center text-[#71717A] mb-3 shadow-[2px_2px_0px_#18181B]">
                    <i class="bi bi-bar-chart-line text-2xl"></i>
                </div>
                <p class="text-sm font-bold text-[#18181B]">Belum Ada Data Tagihan</p>
                <p class="text-xs text-[#71717A] mt-1 max-w-sm">
                    Grafik pergerakan tagihan bulanan akan otomatis terisi setelah data pelanggan dan tagihan ditambahkan ke sistem.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
