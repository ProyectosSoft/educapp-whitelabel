@props(['disabled' => false, 'placeholder' => ''])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['placeholder' => $placeholder, 'class' => 'border-bg-greenLime_700 focus:border-bg-greenLime_500 focus:ring-bg-greenLime_500 rounded-3xl shadow-sm']) !!}>
