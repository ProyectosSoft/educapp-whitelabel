<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-2 bg-greenLime_50 border border-transparent rounded-full font-semibold text-md text-greenLime_500 uppercase tracking-widest hover:bg-greenLime_50 focus:bg-greenLime_50 active:bg-greenLime_50']) }}>
    {{ $slot }}
</button>
