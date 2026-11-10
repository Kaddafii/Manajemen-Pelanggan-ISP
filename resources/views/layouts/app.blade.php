<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Dashboard' }} — Manajemen Pelanggan ISP</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAF8F5] text-[#18181B] font-sans antialiased min-h-screen selection:bg-[#18181B] selection:text-[#FAF8F5]">

    <div class="min-h-screen flex">
        <!-- Sidebar Desktop (Sticky, tidak overlap) -->
        <aside class="hidden md:flex md:w-64 flex-col justify-between bg-[#FFFFFF] border-r-2 border-[#18181B] h-screen sticky top-0 shrink-0 z-30">
            <div class="flex flex-col h-full overflow-y-auto">
                <!-- Brand Header -->
                <div class="p-5 border-b-2 border-[#18181B] flex items-center gap-3 bg-[#FFFFFF]">
                    <div class="w-10 h-10 rounded-xl bg-[#18181B] text-[#FAF8F5] flex items-center justify-center border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] shrink-0">
                        <i class="bi bi-router text-xl"></i>
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-sm font-extrabold uppercase tracking-tight truncate">ISP Manajemen</h1>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full border border-[#18181B] inline-block mt-0.5 {{ auth()->user()->isAdministratorRole() ? 'bg-[#18181B] text-white' : 'bg-[#E4E4E7] text-[#18181B]' }}">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                </div>

                <!-- Navigasi Menu -->
                <nav class="p-4 space-y-2 flex-1">
                    @if(auth()->user()->isAdministratorRole())
                        <!-- Menu Dashboard (Khusus Administrator) -->
                        <a 
                            href="{{ route('dashboard.index') }}" 
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-sm border-2 transition-all {{ request()->routeIs('dashboard.*') ? 'bg-[#18181B] text-[#FAF8F5] border-[#18181B] shadow-[3px_3px_0px_#18181B]' : 'text-[#18181B] border-transparent hover:border-[#18181B] hover:bg-[#F4F4F5]' }}"
                        >
                            <i class="bi bi-speedometer2 text-base"></i>
                            <span>Dashboard</span>
                        </a>
                    @endif

                    <!-- Menu Pelanggan (Administrator & Staff) -->
                    <a 
                        href="{{ route('customers.index') }}" 
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-sm border-2 transition-all {{ request()->routeIs('customers.*') ? 'bg-[#18181B] text-[#FAF8F5] border-[#18181B] shadow-[3px_3px_0px_#18181B]' : 'text-[#18181B] border-transparent hover:border-[#18181B] hover:bg-[#F4F4F5]' }}"
                    >
                        <i class="bi bi-people text-base"></i>
                        <span>Pelanggan</span>
                    </a>

                    <!-- Menu Tagihan (Administrator & Staff) -->
                    <a 
                        href="{{ route('invoices.index') }}" 
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-sm border-2 transition-all {{ request()->routeIs('invoices.*') ? 'bg-[#18181B] text-[#FAF8F5] border-[#18181B] shadow-[3px_3px_0px_#18181B]' : 'text-[#18181B] border-transparent hover:border-[#18181B] hover:bg-[#F4F4F5]' }}"
                    >
                        <i class="bi bi-receipt text-base"></i>
                        <span>Tagihan</span>
                    </a>

                    @if(auth()->user()->isAdministratorRole())
                        <!-- Menu Kelola User (Khusus Administrator) -->
                        <a 
                            href="{{ route('users.index') }}" 
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-sm border-2 transition-all {{ request()->routeIs('users.*') ? 'bg-[#18181B] text-[#FAF8F5] border-[#18181B] shadow-[3px_3px_0px_#18181B]' : 'text-[#18181B] border-transparent hover:border-[#18181B] hover:bg-[#F4F4F5]' }}"
                        >
                            <i class="bi bi-person-gear text-base"></i>
                            <span>Kelola User</span>
                        </a>
                    @endif
                </nav>

                <!-- Footer Sidebar (User Info & Logout) -->
                <div class="p-4 border-t-2 border-[#18181B] bg-[#FFFFFF] space-y-3">
                    <div class="px-1">
                        <p class="text-xs font-bold text-[#18181B] truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-[#71717A] truncate">{{ auth()->user()->email }}</p>
                    </div>

                    <form action="{{ route('logout.terminate') }}" method="POST">
                        @csrf
                        <button 
                            type="submit" 
                            class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl bg-[#FFFFFF] text-[#DC2626] font-bold text-xs uppercase tracking-wider border-2 border-[#DC2626] shadow-[2px_2px_0px_#DC2626] hover:bg-[#FEF2F2] active:translate-x-0.5 active:translate-y-0.5 transition-all cursor-pointer"
                        >
                            <i class="bi bi-box-arrow-right font-bold"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Sidebar Mobile Drawer (Off-canvas) -->
        <div id="mobileBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden"></div>
        <aside id="mobileSidebar" class="fixed top-0 bottom-0 left-0 w-64 bg-[#FFFFFF] border-r-2 border-[#18181B] z-50 transform -translate-x-full transition-transform duration-200 md:hidden flex flex-col justify-between">
            <div class="flex flex-col h-full overflow-y-auto">
                <div class="p-4 border-b-2 border-[#18181B] flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-[#18181B] text-[#FAF8F5] flex items-center justify-center border-2 border-[#18181B]">
                            <i class="bi bi-router text-base"></i>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-tight">ISP Manajemen</span>
                    </div>
                    <button type="button" id="closeMobileMenu" class="p-1 rounded-lg border-2 border-[#18181B] hover:bg-[#F4F4F5]">
                        <i class="bi bi-x text-lg"></i>
                    </button>
                </div>

                <nav class="p-3 space-y-1.5 flex-1">
                    @if(auth()->user()->isAdministratorRole())
                        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-bold text-xs border-2 {{ request()->routeIs('dashboard.*') ? 'bg-[#18181B] text-[#FAF8F5] border-[#18181B]' : 'text-[#18181B] border-transparent' }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                    @endif
                    <a href="{{ route('customers.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-bold text-xs border-2 {{ request()->routeIs('customers.*') ? 'bg-[#18181B] text-[#FAF8F5] border-[#18181B]' : 'text-[#18181B] border-transparent' }}">
                        <i class="bi bi-people"></i>
                        <span>Pelanggan</span>
                    </a>
                    <a href="{{ route('invoices.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-bold text-xs border-2 {{ request()->routeIs('invoices.*') ? 'bg-[#18181B] text-[#FAF8F5] border-[#18181B]' : 'text-[#18181B] border-transparent' }}">
                        <i class="bi bi-receipt"></i>
                        <span>Tagihan</span>
                    </a>
                    @if(auth()->user()->isAdministratorRole())
                        <a href="{{ route('users.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg font-bold text-xs border-2 {{ request()->routeIs('users.*') ? 'bg-[#18181B] text-[#FAF8F5] border-[#18181B]' : 'text-[#18181B] border-transparent' }}">
                            <i class="bi bi-person-gear"></i>
                            <span>Kelola User</span>
                        </a>
                    @endif
                </nav>

                <div class="p-3 border-t-2 border-[#18181B] bg-[#FFFFFF]">
                    <p class="text-xs font-bold text-[#18181B] truncate">{{ auth()->user()->name }}</p>
                    <form action="{{ route('logout.terminate') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full py-1.5 rounded-lg bg-[#FFFFFF] text-[#DC2626] font-bold text-xs border-2 border-[#DC2626]">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Area Konten Kanan (Normal Document Flow) -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Navbar Header -->
            <header class="w-full bg-[#FFFFFF] border-b-2 border-[#18181B] px-4 sm:px-6 py-3.5 flex items-center justify-between sticky top-0 z-20">
                <div class="flex items-center gap-3">
                    <button type="button" id="openMobileMenu" class="md:hidden p-1.5 rounded-lg border-2 border-[#18181B] text-[#18181B]">
                        <i class="bi bi-list text-xl"></i>
                    </button>
                    <h2 class="text-base sm:text-lg font-extrabold uppercase tracking-tight text-[#18181B]">
                        {{ $header ?? 'Dashboard' }}
                    </h2>
                </div>

                <div class="text-xs font-bold text-[#71717A]">
                    {{ auth()->user()->name }}
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto space-y-6">
                    <!-- Alert Notifikasi Flash Session -->
                    @if (session('success'))
                        <div class="p-4 rounded-xl border-2 border-[#059669] bg-[#ECFDF5] shadow-[3px_3px_0px_#059669] flex items-start gap-3">
                            <i class="bi bi-check-circle-fill text-base text-[#059669] mt-0.5"></i>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-[#065F46]">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 rounded-xl border-2 border-[#DC2626] bg-[#FEF2F2] shadow-[3px_3px_0px_#DC2626] flex items-start gap-3">
                            <i class="bi bi-exclamation-triangle-fill text-base text-[#DC2626] mt-0.5"></i>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-[#991B1B]">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <!-- Script Drawer Mobile Sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openBtn = document.getElementById('openMobileMenu');
            const closeBtn = document.getElementById('closeMobileMenu');
            const mobileSidebar = document.getElementById('mobileSidebar');
            const backdrop = document.getElementById('mobileBackdrop');

            function toggleDrawer(open) {
                if (!mobileSidebar || !backdrop) return;
                if (open) {
                    backdrop.classList.remove('hidden');
                    mobileSidebar.classList.remove('-translate-x-full');
                } else {
                    backdrop.classList.add('hidden');
                    mobileSidebar.classList.add('-translate-x-full');
                }
            }

            if (openBtn) openBtn.addEventListener('click', () => toggleDrawer(true));
            if (closeBtn) closeBtn.addEventListener('click', () => toggleDrawer(false));
            if (backdrop) backdrop.addEventListener('click', () => toggleDrawer(false));
        });
    </script>
</body>
</html>
