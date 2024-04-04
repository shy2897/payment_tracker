<style>
    .text-input {
        box-shadow: 0 0 3px 0 #000;
    }
</style>

@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'text-input border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-3xl shadow-sm']) !!}>
