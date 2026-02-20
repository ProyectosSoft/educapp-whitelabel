<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-2 bg-greenLime_500 border border-transparent rounded-full font-semibold text-xs text-greenLime_50 uppercase tracking-widest hover:bg-greenLime_400 focus:bg-greenLime_400 active:bg-greenLime_400']) }}>
    {{ $slot }}
</button>
