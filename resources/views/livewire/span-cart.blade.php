<div>
    @if ($carlist !== null && $carlist->count())
    <span class="absolute top-0 right-0 inline-flex items-center justify-center text-xs font-bold leading-none text-greenLime_500 w-4 h-4 bg-greenLime_50 rounded-full">{{ $carlist->count()}}</span>
    @endif
</div>
