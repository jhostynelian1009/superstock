@if (session('success'))
    <div class="mb-6 rounded-sm border border-[#e3e3e0] bg-slate-50 dark:bg-slate-900/60 px-4 py-3 text-sm text-[#16a34a] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#16a34a]" role="alert">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 rounded-sm border border-brand-primary bg-slate-50 dark:bg-slate-900/60 px-4 py-3 text-sm text-brand-primary dark:border-[#3E3E3A] dark:bg-[#161615]" role="alert">
        {{ session('error') }}
    </div>
@endif
