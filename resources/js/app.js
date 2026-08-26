/**
 * Warriors Educare - Global Searchable Dropdown Initializer
 * Uses SlimSelect with modern responsive search and theme integration.
 */
(function () {
    window.initSearchableSelects = function (root = document) {
        if (typeof SlimSelect === 'undefined') return;

        const selects = root.querySelectorAll('select:not([data-no-search]):not(.no-search)');
        selects.forEach((select) => {
            if (select.dataset.slimSelectInitialized === 'true') return;
            if (select.closest('template') || select.classList.contains('hidden-select')) return;

            try {
                let placeholderText =
                    select.getAttribute('placeholder') ||
                    select.getAttribute('data-placeholder');

                if (!placeholderText && select.options.length > 0) {
                    const firstOpt = select.options[0];
                    if (
                        firstOpt &&
                        (firstOpt.value === '' ||
                            firstOpt.text.toLowerCase().includes('select') ||
                            firstOpt.text.toLowerCase().includes('choose') ||
                            firstOpt.text.toLowerCase().includes('any'))
                    ) {
                        placeholderText = firstOpt.text;
                    }
                }

                if (!placeholderText) {
                    placeholderText = 'Select option';
                }

                const hasEmptyOption = Array.from(select.options).some(
                    (o) => o.value === ''
                );

                const slim = new SlimSelect({
                    select: select,
                    settings: {
                        showSearch: true,
                        searchPlaceholder: 'Type to search...',
                        searchText: 'No options found',
                        searchHighlight: true,
                        placeholderText: placeholderText,
                        allowDeselect: false,
                        closeOnSelect: true,
                    },
                    events: {
                        afterChange: (newVal) => {
                            select.dispatchEvent(new Event('change', { bubbles: true }));
                            select.dispatchEvent(new Event('input', { bubbles: true }));
                        },
                    },
                });

                select.dataset.slimSelectInitialized = 'true';
                select._slimSelect = slim;
            } catch (err) {
                console.warn('SlimSelect initialization error on select:', select, err);
            }
        });
    };

    window.refreshSearchableSelect = function (select) {
        if (select && select._slimSelect) {
            try {
                select._slimSelect.setData(select._slimSelect.getDataFromSelect());
            } catch (e) {
                try {
                    select._slimSelect.destroy();
                    delete select.dataset.slimSelectInitialized;
                    window.initSearchableSelects(select.parentElement || document);
                } catch (err) {}
            }
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            window.initSearchableSelects();
        });
    } else {
        window.initSearchableSelects();
    }

    // Auto-detect dynamic selects added to DOM
    if (window.MutationObserver) {
        let debounceTimer = null;
        const observer = new MutationObserver((mutations) => {
            let hasNewSelect = false;
            mutations.forEach((mutation) => {
                if (mutation.addedNodes.length) {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === 1) {
                            if (
                                node.tagName === 'SELECT' &&
                                !node.dataset.slimSelectInitialized &&
                                !node.closest('.ss-main')
                            ) {
                                hasNewSelect = true;
                            } else if (
                                node.querySelectorAll &&
                                node.querySelectorAll(
                                    'select:not([data-no-search]):not(.no-search)'
                                ).length > 0
                            ) {
                                hasNewSelect = true;
                            }
                        }
                    });
                }
            });

            if (hasNewSelect) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    window.initSearchableSelects();
                }, 50);
            }
        });

        if (document.body) {
            observer.observe(document.body, { childList: true, subtree: true });
        } else {
            document.addEventListener('DOMContentLoaded', () => {
                observer.observe(document.body, { childList: true, subtree: true });
            });
        }
    }
})();
