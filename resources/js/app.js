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

                // Automatically watch for dynamic option additions/removals, text changes, or disabled state changes
                if (window.MutationObserver && !select._slimObserver) {
                    const observer = new MutationObserver((mutations) => {
                        if (select._isUpdatingFromSlim) return;
                        let shouldRefresh = false;
                        for (let i = 0; i < mutations.length; i++) {
                            const m = mutations[i];
                            if (m.type === 'childList') {
                                shouldRefresh = true;
                                break;
                            }
                            if (m.type === 'attributes' && m.attributeName === 'disabled') {
                                shouldRefresh = true;
                                break;
                            }
                            if (m.type === 'characterData') {
                                shouldRefresh = true;
                                break;
                            }
                        }
                        if (shouldRefresh) {
                            clearTimeout(select._refreshDebounce);
                            select._refreshDebounce = setTimeout(() => {
                                window.refreshSearchableSelect(select);
                            }, 25);
                        }
                    });
                    observer.observe(select, {
                        childList: true,
                        subtree: true,
                        characterData: true,
                        attributes: true,
                        attributeFilter: ['disabled']
                    });
                    select._slimObserver = observer;
                }
            } catch (err) {
                console.warn('SlimSelect initialization error on select:', select, err);
            }
        });
    };

    window.refreshSearchableSelect = function (select) {
        if (!select || !select._slimSelect) return;
        try {
            const slim = select._slimSelect;
            select._isUpdatingFromSlim = true;

            let placeholderText =
                select.getAttribute('placeholder') ||
                select.getAttribute('data-placeholder');

            const optionsData = [];
            let hasSelected = false;

            Array.from(select.options).forEach((opt, idx) => {
                const isPlaceholder =
                    opt.value === '' &&
                    (idx === 0 ||
                        opt.text.toLowerCase().includes('select') ||
                        opt.text.toLowerCase().includes('first') ||
                        opt.text.toLowerCase().includes('loading') ||
                        opt.text.toLowerCase().includes('choose') ||
                        opt.text.toLowerCase().includes('any'));

                if (isPlaceholder && !placeholderText) {
                    placeholderText = opt.text;
                }

                const isSelected = opt.selected || opt.hasAttribute('selected');
                optionsData.push({
                    text: opt.text,
                    value: opt.value,
                    selected: isSelected,
                    placeholder: isPlaceholder,
                    disabled: opt.disabled,
                });

                if (isSelected && opt.value !== '') {
                    hasSelected = true;
                }
            });

            slim.setData(optionsData);

            if (select.value && select.value !== '') {
                slim.setSelected(String(select.value), false);
            } else if (!hasSelected) {
                slim.setSelected('', false);
            }

            if (select.disabled) {
                slim.disable();
            } else {
                slim.enable();
            }
        } catch (e) {
            console.warn('Error refreshing SlimSelect:', e);
            try {
                if (select._slimObserver) {
                    select._slimObserver.disconnect();
                    delete select._slimObserver;
                }
                select._slimSelect.destroy();
                delete select.dataset.slimSelectInitialized;
                window.initSearchableSelects(select.parentElement || document);
            } catch (err) {}
        } finally {
            setTimeout(() => {
                if (select) select._isUpdatingFromSlim = false;
            }, 60);
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
