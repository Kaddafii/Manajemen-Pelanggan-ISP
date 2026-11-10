<x-app-layout>
    <x-slot:title>Daftar Pengguna</x-slot:title>
    <x-slot:header>Kelola Pengguna</x-slot:header>

    <div class="space-y-5">
        <!-- Top Action Bar (Pencarian, Filter Role & Tombol Tambah) -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <!-- Form Pencarian & Filter Role -->
            <form action="{{ route('users.index') }}" method="GET" class="flex flex-wrap items-center gap-2 flex-1 max-w-xl">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                @if(request('direction'))
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                @endif

                <div class="relative flex-1 min-w-[200px]">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#71717A]">
                        <i class="bi bi-search text-sm"></i>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $searchKeyword }}" 
                        placeholder="Cari nama atau email pengguna..." 
                        class="w-full pl-9 pr-3 py-2 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[2px_2px_0px_#18181B] focus:outline-none focus:ring-0 placeholder-[#A1A1AA]"
                    >
                </div>

                <!-- Filter Role Kustom Dropdown Taktil -->
                <div class="w-36 sm:w-40">
                    <x-tactile-select 
                        name="role" 
                        id="user_role_filter" 
                        :value="$roleFilter ?? ''" 
                        :options="['' => 'Semua Role', 'Administrator' => 'Administrator', 'Staff' => 'Staff']" 
                        placeholder="Semua Role"
                        :autoSubmitForm="true"
                    />
                </div>

                <button 
                    type="submit" 
                    class="px-3.5 py-2 rounded-xl bg-[#18181B] text-[#FAF8F5] font-bold text-xs border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#27272A] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                >
                    Cari
                </button>

                @if(!empty($searchKeyword) || !empty($roleFilter))
                    <a 
                        href="{{ route('users.index') }}" 
                        class="px-3 py-2 rounded-xl bg-[#FFFFFF] text-[#18181B] font-bold text-xs border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                        title="Reset Filter"
                    >
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>

            <!-- Tombol Tambah Pengguna Baru -->
            <a 
                href="{{ route('users.create') }}" 
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#18181B] text-[#FAF8F5] font-bold text-xs uppercase tracking-wider border-2 border-[#18181B] shadow-[3px_3px_0px_#18181B] hover:bg-[#27272A] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer shrink-0"
            >
                <i class="bi bi-plus-lg font-bold"></i>
                <span>Tambah User</span>
            </a>
        </div>

        <!-- Tabel Data Pengguna -->
        <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl shadow-[6px_6px_0px_#18181B] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-[#FAF8F5] border-b-2 border-[#18181B] text-[#18181B]">
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider w-12 text-center">No</th>
                            
                            {{-- Sorting Nama --}}
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider">
                                <a href="{{ route('users.index', ['sort' => 'name', 'direction' => ($sortColumn === 'name' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => $searchKeyword, 'role' => $roleFilter]) }}" class="inline-flex items-center gap-1.5 hover:underline">
                                    <span>Nama</span>
                                    <i class="bi bi-arrow-down-up text-[10px]"></i>
                                </a>
                            </th>

                            {{-- Sorting Email --}}
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider">
                                <a href="{{ route('users.index', ['sort' => 'email', 'direction' => ($sortColumn === 'email' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => $searchKeyword, 'role' => $roleFilter]) }}" class="inline-flex items-center gap-1.5 hover:underline">
                                    <span>Email</span>
                                    <i class="bi bi-arrow-down-up text-[10px]"></i>
                                </a>
                            </th>

                            {{-- Sorting Role --}}
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider text-center">
                                <a href="{{ route('users.index', ['sort' => 'role', 'direction' => ($sortColumn === 'role' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => $searchKeyword, 'role' => $roleFilter]) }}" class="inline-flex items-center gap-1.5 hover:underline">
                                    <span>Role</span>
                                    <i class="bi bi-arrow-down-up text-[10px]"></i>
                                </a>
                            </th>

                            {{-- Tanggal Dibuat --}}
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider text-center">
                                <a href="{{ route('users.index', ['sort' => 'created_at', 'direction' => ($sortColumn === 'created_at' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => $searchKeyword, 'role' => $roleFilter]) }}" class="inline-flex items-center gap-1.5 hover:underline">
                                    <span>Tanggal Dibuat</span>
                                    <i class="bi bi-arrow-down-up text-[10px]"></i>
                                </a>
                            </th>

                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-[#18181B]">
                        @forelse ($users as $user)
                            <tr class="hover:bg-[#FAF8F5] transition-colors">
                                <td class="py-3 px-4 text-center font-bold text-[#71717A]">
                                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-bold text-[#18181B]">{{ $user->name }}</span>
                                    @if(auth()->id() === $user->id)
                                        <span class="text-[10px] text-[#71717A] font-semibold ml-1">(Anda)</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-semibold text-[#18181B]">
                                    {{ $user->email }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if ($user->isAdministratorRole())
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border border-[#18181B] bg-[#18181B] text-[#FAF8F5]">
                                            Administrator
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border border-[#18181B] bg-[#F4F4F5] text-[#18181B]">
                                            Staff
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center text-[11px] text-[#71717A] font-medium whitespace-nowrap">
                                    <div class="flex flex-col items-center">
                                        <span class="font-bold text-[#18181B]">{{ $user->created_at ? $user->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') . ' WIB' : '-' }}</span>
                                        @if ($user->updated_at && $user->created_at && $user->updated_at->diffInSeconds($user->created_at) > 5)
                                            <span class="text-[10px] text-[#71717A] mt-0.5" title="Waktu terakhir data diperbarui">
                                                (Diperbarui: {{ $user->updated_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB)
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="inline-flex items-center gap-2">
                                        <!-- Tombol Edit User -->
                                        <a 
                                            href="{{ route('users.edit', $user) }}" 
                                            class="w-8 h-8 inline-flex items-center justify-center rounded-lg border-2 border-[#18181B] bg-[#FFFFFF] text-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                                            title="Ubah Data Pengguna"
                                        >
                                            <i class="bi bi-pencil-square text-xs"></i>
                                        </a>

                                        <!-- Tombol Hapus User (Tidak dapat menghapus akun sendiri) -->
                                        @if(auth()->id() !== $user->id)
                                            <button 
                                                type="button" 
                                                data-delete-user-id="{{ $user->id }}"
                                                data-delete-user-name="{{ $user->name }}"
                                                data-delete-user-email="{{ $user->email }}"
                                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg border-2 border-[#DC2626] bg-[#FFFFFF] text-[#DC2626] shadow-[2px_2px_0px_#DC2626] hover:bg-[#FEF2F2] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#DC2626] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#DC2626] transition-all cursor-pointer"
                                                title="Hapus Pengguna"
                                            >
                                                <i class="bi bi-trash3 text-xs"></i>
                                            </button>
                                        @else
                                            <span 
                                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg border-2 border-[#E4E4E7] bg-[#F4F4F5] text-[#A1A1AA] cursor-not-allowed" 
                                                title="Anda tidak dapat menghapus akun Anda sendiri"
                                            >
                                                <i class="bi bi-lock text-xs"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-xl bg-[#FAF8F5] border-2 border-[#18181B] flex items-center justify-center text-[#71717A] mb-3 shadow-[2px_2px_0px_#18181B]">
                                            <i class="bi bi-people text-xl"></i>
                                        </div>
                                        <p class="text-sm font-bold text-[#18181B]">Belum Ada Pengguna Ditemukan</p>
                                        <p class="text-xs text-[#71717A] mt-0.5">Silakan tambahkan pengguna baru melalui tombol di atas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Area Pagination Kustom Taktil -->
            @if ($users->hasPages())
                <div class="p-4 border-t-2 border-[#18181B] bg-[#FAF8F5]">
                    {{ $users->links('components.tactile-pagination') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Pengguna -->
    <div id="deleteUserModalBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity"></div>
    <div id="deleteUserConfirmationModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl max-w-sm w-full p-6 shadow-[6px_6px_0px_#18181B] text-center">
            <div class="w-12 h-12 rounded-xl bg-[#FEF2F2] border-2 border-[#DC2626] text-[#DC2626] flex items-center justify-center mx-auto mb-4 shadow-[2px_2px_0px_#DC2626]">
                <i class="bi bi-person-x-fill text-xl"></i>
            </div>
            <h4 class="text-base font-extrabold uppercase text-[#18181B]">Hapus Pengguna?</h4>
            <p class="text-xs text-[#71717A] mt-1.5 leading-relaxed">
                Akun pengguna <strong id="deleteUserName" class="text-[#18181B]"></strong> (<span id="deleteUserEmail"></span>) akan dihapus secara permanen dari sistem.
            </p>

            <div class="mt-6 flex items-center justify-center gap-3">
                <button 
                    type="button" 
                    id="cancelDeleteUserButton" 
                    class="flex-1 py-2 rounded-xl bg-[#FFFFFF] text-[#18181B] font-bold text-xs border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                >
                    Batal
                </button>

                <form id="deleteUserForm" method="POST" action="" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit" 
                        class="w-full py-2 rounded-xl bg-[#DC2626] text-[#FFFFFF] font-bold text-xs uppercase tracking-wider border-2 border-[#DC2626] shadow-[2px_2px_0px_#18181B] hover:bg-[#B91C1C] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                    >
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
