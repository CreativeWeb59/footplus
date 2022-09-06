@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-white text-xl font-medium leading-5 text-white
            focus:outline-none focus:border-white transition duration-150 ease-in-out
            hover:text-yellow-500 hover:border-yellow-500'

            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-xl font-medium leading-5 text-yellow-500
            hover:text-yellow-500 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out
            hover:text-white hover:border-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
