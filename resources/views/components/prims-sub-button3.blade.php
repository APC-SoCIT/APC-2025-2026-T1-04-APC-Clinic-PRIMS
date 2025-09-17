<button 
    {{ $attributes->merge([
        'type' => $attributes->get('href') ? 'button' : 'submit', 
        'onclick' => $attributes->get('href') ? "window.location.href='{$attributes->get('href')}'" : '',
        'class' => 'inline-block self-start justify-center items-center px-4 py-2 bg-zinc-200 border border-transparent rounded-lg font-bold text-md text-sub-header-1 tracking-normal hover:text-prims-yellow-1 hover:bg-prims-azure-600 focus:bg-prims-azure-700 active:bg-prims-azure-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150'
    ]) }}
>
    {{ $slot }}
</button>