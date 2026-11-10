// Inisialisasi komponen kustom dropdown taktil dengan keyboard navigation dan outside click
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
        const items = container.querySelectorAll('[data-dropdown-item]');

        if (!trigger || !menu || !input) return;

        function openDropdown() {
            closeAllDropdowns(container);
            menu.classList.remove('hidden');
            trigger.setAttribute('aria-expanded', 'true');
            if (arrow) arrow.classList.add('rotate-180');
        }

        function closeDropdown() {
            menu.classList.add('hidden');
            trigger.setAttribute('aria-expanded', 'false');
            if (arrow) arrow.classList.remove('rotate-180');
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
            if (selectedValue === 'Aktif') {
                triggerDot.classList.add('bg-[#10B981]');
            } else if (selectedValue === 'Suspend') {
                triggerDot.classList.add('bg-[#F59E0B]');
            } else if (selectedValue === 'Putus') {
                triggerDot.classList.add('bg-[#EF4444]');
            } else {
                triggerDot.classList.add('bg-[#71717A]');
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

            // Dispatch event change pada hidden input
            input.dispatchEvent(new Event('change', { bubbles: true }));
            input.dispatchEvent(new Event('input', { bubbles: true }));

            closeDropdown();
            trigger.focus();
        }

        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleDropdown();
        });

        items.forEach((item, index) => {
            item.addEventListener('click', function (e) {
                e.stopPropagation();
                selectItem(item);
            });

            item.addEventListener('keydown', function (e) {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    const nextIndex = (index + 1) % items.length;
                    items[nextIndex].focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    const prevIndex = (index - 1 + items.length) % items.length;
                    items[prevIndex].focus();
                } else if (e.key === 'Escape') {
                    e.preventDefault();
                    closeDropdown();
                    trigger.focus();
                } else if (e.key === 'Tab') {
                    closeDropdown();
                }
            });
        });

        trigger.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown' || e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openDropdown();
                const selectedItem = container.querySelector('[aria-selected="true"]') || items[0];
                if (selectedItem) selectedItem.focus();
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
