@if(session('success') || session('error') || (isset($errors) && $errors->any()))
<div id="toast-container" class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 max-w-sm w-full pointer-events-none">
    @if(session('success'))
        <div class="toast-item bg-white dark:bg-slate-900 border-l-4 border-emerald-500 text-slate-800 dark:text-slate-100 p-4 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.08)] dark:shadow-[0_10px_30px_rgba(0,0,0,0.3)] flex items-start gap-3 pointer-events-auto transform translate-x-[120%] transition-all duration-500 ease-out" data-type="success">
            <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-500 dark:text-emerald-400 flex items-center justify-center flex-shrink-0 shadow-inner">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="flex-1">
                <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Success</p>
                <p class="text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-350 mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="dismissToast(this.parentElement)" class="text-slate-400 hover:text-slate-655 dark:hover:text-slate-300 transition flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="toast-item bg-white dark:bg-slate-900 border-l-4 border-rose-500 text-slate-800 dark:text-slate-100 p-4 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.08)] dark:shadow-[0_10px_30px_rgba(0,0,0,0.3)] flex items-start gap-3 pointer-events-auto transform translate-x-[120%] transition-all duration-500 ease-out" data-type="error">
            <div class="w-8 h-8 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-500 dark:text-rose-400 flex items-center justify-center flex-shrink-0 shadow-inner">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div class="flex-1">
                <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Error</p>
                <p class="text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-350 mt-0.5">{{ session('error') }}</p>
            </div>
            <button onclick="dismissToast(this.parentElement)" class="text-slate-400 hover:text-slate-655 dark:hover:text-slate-300 transition flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        @foreach($errors->all() as $error)
            <div class="toast-item bg-white dark:bg-slate-900 border-l-4 border-rose-500 text-slate-800 dark:text-slate-100 p-4 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.08)] dark:shadow-[0_10px_30px_rgba(0,0,0,0.3)] flex items-start gap-3 pointer-events-auto transform translate-x-[120%] transition-all duration-500 ease-out" data-type="error">
                <div class="w-8 h-8 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-500 dark:text-rose-400 flex items-center justify-center flex-shrink-0 shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Validation Error</p>
                    <p class="text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-350 mt-0.5">{{ $error }}</p>
                </div>
                <button onclick="dismissToast(this.parentElement)" class="text-slate-400 hover:text-slate-655 dark:hover:text-slate-300 transition flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endforeach
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('.toast-item');
        toasts.forEach((toast, idx) => {
            setTimeout(() => {
                toast.classList.remove('translate-x-[120%]');
                toast.classList.add('translate-x-0');
            }, (idx + 1) * 150);

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                dismissToast(toast);
            }, 5000 + (idx * 200));
        });
    });

    function dismissToast(toast) {
        if (!toast) return;
        toast.classList.remove('translate-x-0');
        toast.classList.add('translate-x-[120%]', 'opacity-0');
        setTimeout(() => {
            toast.remove();
        }, 500);
    }
</script>
@endif
