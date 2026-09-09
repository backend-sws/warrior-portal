<script>
/**
 * Global Helper to Copy Job Link and show visual feedback & toast.
 */
function copyJobUrl(url, btnElement) {
    if (!url) {
        url = window.location.href;
    }

    function showFeedback(success) {
        if (btnElement) {
            if (!btnElement.dataset.originalHtml) {
                btnElement.dataset.originalHtml = btnElement.innerHTML;
            }
            const originalContent = btnElement.dataset.originalHtml;

            if (success) {
                btnElement.classList.add('!bg-emerald-600', '!text-white', '!border-emerald-600');
                btnElement.innerHTML = '<i class="fas fa-check text-xs"></i> <span>Copied!</span>';
            } else {
                btnElement.classList.add('!bg-rose-600', '!text-white');
                btnElement.innerHTML = '<i class="fas fa-exclamation text-xs"></i> <span>Failed</span>';
            }

            setTimeout(() => {
                btnElement.innerHTML = originalContent;
                btnElement.classList.remove('!bg-emerald-600', '!bg-rose-600', '!text-white', '!border-emerald-600');
            }, 2500);
        }

        // Floating Toast Notification
        let toast = document.getElementById('global-share-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'global-share-toast';
            document.body.appendChild(toast);
        }

        if (success) {
            toast.className = 'fixed bottom-6 right-6 z-[99999] flex items-center gap-3 px-5 py-3.5 bg-[#031b4e] text-white border border-blue-400/40 rounded-2xl shadow-2xl transition-all duration-300 transform translate-y-0 opacity-100';
            toast.innerHTML = `
                <div class="w-9 h-9 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-base shrink-0 shadow-inner">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="text-left">
                    <div class="text-xs font-black uppercase tracking-wider text-sky-400">Job Link Copied!</div>
                    <div class="text-xs text-slate-200 mt-0.5">Send this link to anyone. Opening it takes them directly to this job vacancy.</div>
                </div>
                <button type="button" onclick="this.parentElement.classList.add('translate-y-12', 'opacity-0', 'pointer-events-none')" class="text-slate-400 hover:text-white p-1 ml-2">
                    <i class="fas fa-times text-xs"></i>
                </button>
            `;
        } else {
            toast.className = 'fixed bottom-6 right-6 z-[99999] flex items-center gap-3 px-5 py-3.5 bg-rose-950 text-rose-100 border border-rose-500/40 rounded-2xl shadow-2xl transition-all duration-300 transform translate-y-0 opacity-100';
            toast.innerHTML = `
                <div class="w-9 h-9 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center text-base shrink-0">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="text-left">
                    <div class="text-xs font-black uppercase tracking-wider text-rose-300">Copy Failed</div>
                    <div class="text-xs text-rose-200 mt-0.5">Please copy the URL manually from your address bar.</div>
                </div>
            `;
        }

        clearTimeout(toast.dismissTimeout);
        toast.dismissTimeout = setTimeout(() => {
            if (toast) {
                toast.className = 'fixed bottom-6 right-6 z-[99999] flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-2xl transition-all duration-300 transform translate-y-12 opacity-0 pointer-events-none';
            }
        }, 3500);
    }

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url)
            .then(() => showFeedback(true))
            .catch(() => fallbackCopy(url));
    } else {
        fallbackCopy(url);
    }

    function fallbackCopy(text) {
        try {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            const successful = document.execCommand('copy');
            document.body.removeChild(textArea);
            showFeedback(successful);
        } catch (err) {
            showFeedback(false);
        }
    }
}
window.copyJobUrl = copyJobUrl;
</script>
