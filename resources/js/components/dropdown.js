// Inisialisasi komponen kustom dropdown taktil dengan keyboard navigation, searchbar, dan auto-submit
document.addEventListener('DOMContentLoaded', function () {
    const dropdownContainers = document.querySelectorAll('[data-dropdown-container]');

    function closeAllDropdowns(exceptContainer = null) {
        dropdownContainers.forEach(container => {
            if (container !== exceptContainer) {
                const menu = container.querySelector('[data-dropdown-menu]');
                const trigger = container.querySelector('[data-dropdown-trigger]');
                const arrow = container.querySelector('[data-dropdown-arrow]');

                if (menu && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    if (trigger) trigger.setAttribute('aria-expanded', 'false');
                    if (arrow) arrow.classList.remove('rotate-180');
                }
            }
        });
    }

    dropdownContainers.forEach(container => {
        const trigger = container.querySelector('[data-dropdown-trigger]');
        const menu = container.querySelector('[data-dropdown-menu]');
        const input = container.querySelector('[data-dropdown-input]');
        const label = container.querySelector('[data-dropdown-label]');
        const arrow = container.querySelector('[data-dropdown-arrow]');
        const triggerDot = container.querySelector('[data-dropdown-trigger-dot]');
        const searchInput = container.querySelector('[data-dropdown-search]');
        const noResults = container.querySelector('[data-dropdown-no-results]');
        const items = container.querySelectorAll('[data-dropdown-item]');

        if (!trigger || !menu || !input) return;

        function resetSearchFilter() {
            if (searchInput) {
                searchInput.value = '';
                items.forEach(item => {
                    item.classList.remove('hidden');
                    item.classList.add('flex');
                });
                if (noResults) noResults.classList.add('hidden');
            }
        }

        function openDropdown() {
            closeAllDropdowns(container);
            resetSearchFilter();
            menu.classList.remove('hidden');
            trigger.setAttribute('aria-expanded', 'true');
            if (arrow) arrow.classList.add('rotate-180');

            if (searchInput) {
                setTimeout(() => searchInput.focus(), 60);
            }
        }

        function closeDropdown() {
            menu.classList.add('hidden');
            trigger.setAttribute('aria-expanded', 'false');
            if (arrow) arrow.classList.remove('rotate-180');
            resetSearchFilter();
        }

        function toggleDropdown() {
            if (menu.classList.contains('hidden')) {
                openDropdown();
            } else {
                closeDropdown();
            }
        }

        function updateTriggerDot(selectedValue) {
            if (!triggerDot) return;

            triggerDot.classList.remove('hidden', 'bg-[#10B981]', 'bg-[#F59E0B]', 'bg-[#EF4444]', 'bg-[#71717A]');
            if (selectedValue === 'Aktif' || selectedValue === 'Lunas') {
                triggerDot.classList.add('bg-[#10B981]');
            } else if (selectedValue === 'Suspend' || selectedValue === 'Belum Bayar') {
                triggerDot.classList.add('bg-[#F59E0B]');
            } else if (selectedValue === 'Putus') {
                triggerDot.classList.add('bg-[#EF4444]');
            } else {
                triggerDot.classList.add('hidden');
            }
        }

        function selectItem(itemElement) {
            const selectedValue = itemElement.getAttribute('data-value');
            const selectedLabel = itemElement.getAttribute('data-label');

            input.value = selectedValue;
            if (label) label.textContent = selectedLabel;

            updateTriggerDot(selectedValue);

            items.forEach(otherItem => {
                const checkIcon = otherItem.querySelector('[data-dropdown-check]');
                if (otherItem === itemElement) {
                    otherItem.setAttribute('aria-selected', 'true');
                    otherItem.className = 'w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs font-bold transition-all text-left cursor-pointer bg-[#18181B] text-[#FAF8F5]';
                    if (checkIcon) {
                        checkIcon.classList.remove('hidden');
                        checkIcon.classList.add('block', 'text-[#FAF8F5]');
                    }
                } else {
                    otherItem.setAttribute('aria-selected', 'false');
                    otherItem.className = 'w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs font-bold transition-all text-left cursor-pointer text-[#18181B] hover:bg-[#FAF8F5] hover:translate-x-0.5';
                    if (checkIcon) {
                        checkIcon.classList.add('hidden');
                        checkIcon.classList.remove('block');
                    }
                }
            });

            // Dispatch event change dan input pada hidden input
            input.dispatchEvent(new Event('change', { bubbles: true }));
            input.dispatchEvent(new Event('input', { bubbles: true }));

            closeDropdown();
            trigger.focus();

            // Auto-submit formulir jika atribut data-auto-submit bernilai true
            if (container.getAttribute('data-auto-submit') === 'true' && input.form) {
                input.form.submit();
            }
        }

        // Event listener pada trigger tombol pembuka
        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleDropdown();
        });

        // Event listener live search filter
        if (searchInput) {
            searchInput.addEventListener('click', function (e) {
                e.stopPropagation();
            });

            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                let visibleCount = 0;

                items.forEach(item => {
                    const labelText = (item.getAttribute('data-label') || '').toLowerCase();
                    const valueText = (item.getAttribute('data-value') || '').toLowerCase();

                    if (labelText.includes(query) || valueText.includes(query)) {
                        item.classList.remove('hidden');
                        item.classList.add('flex');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                        item.classList.remove('flex');
                    }
                });

                if (noResults) {
                    if (visibleCount === 0) {
                        noResults.classList.remove('hidden');
                    } else {
                        noResults.classList.add('hidden');
                    }
                }
            });

            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    const firstVisibleItem = Array.from(items).find(item => !item.classList.contains('hidden'));
                    if (firstVisibleItem) firstVisibleItem.focus();
                } else if (e.key === 'Escape') {
                    e.preventDefault();
                    closeDropdown();
                    trigger.focus();
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    const firstVisibleItem = Array.from(items).find(item => !item.classList.contains('hidden'));
                    if (firstVisibleItem) selectItem(firstVisibleItem);
                }
            });
        }

        // Event listener setiap item pilihan
        items.forEach((item, index) => {
            item.addEventListener('click', function (e) {
                e.stopPropagation();
                selectItem(item);
            });

            item.addEventListener('keydown', function (e) {
                const visibleItems = Array.from(items).filter(it => !it.classList.contains('hidden'));
                const currentIndex = visibleItems.indexOf(item);

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    const nextIndex = (currentIndex + 1) % visibleItems.length;
                    visibleItems[nextIndex].focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (currentIndex === 0 && searchInput) {
                        searchInput.focus();
                    } else {
                        const prevIndex = (currentIndex - 1 + visibleItems.length) % visibleItems.length;
                        visibleItems[prevIndex].focus();
                    }
                } else if (e.key === 'Escape') {
                    e.preventDefault();
                    closeDropdown();
                    trigger.focus();
                } else if (e.key === 'Tab') {
                    closeDropdown();
                }
            });
        });

        // Navigasi keyboard pada trigger tombol utama
        trigger.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown' || e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openDropdown();
                if (!searchInput) {
                    const selectedItem = container.querySelector('[aria-selected="true"]') || items[0];
                    if (selectedItem) selectedItem.focus();
                }
            } else if (e.key === 'Escape') {
                e.preventDefault();
                closeDropdown();
            }
        });
    });

    // Menutup dropdown saat pengguna mengklik area luar (light dismiss)
    document.addEventListener('click', function (e) {
        if (!e.target.closest('[data-dropdown-container]')) {
            closeAllDropdowns();
        }
    });
});
