<button {{ $attributes->merge(['type' => 'submit', 'class' => 'm-4 inline-flex items-center justify-center px-8 py-1 bg-creamcard rounded-md shadow-quadrupleNonHover text-redb font-bold hover:shadow-quadrupleHover hover:text-greenbg transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
