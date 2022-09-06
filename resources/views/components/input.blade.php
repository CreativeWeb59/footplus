@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-red-300 focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50']) !!}>
