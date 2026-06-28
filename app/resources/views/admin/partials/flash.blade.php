@if (session('success'))
    <div class="mb-6 rounded-sm border border-[#e3e3e0] bg-[#fff2f2] px-4 py-3 text-sm text-[#16a34a] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#16a34a]" role="alert">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 rounded-sm border border-[#F53003] bg-[#fff2f2] px-4 py-3 text-sm text-[#F53003] dark:border-[#3E3E3A] dark:bg-[#161615]" role="alert">
        {{ session('error') }}
    </div>
@endif
