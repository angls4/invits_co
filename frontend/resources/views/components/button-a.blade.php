@props(['disabled' => false])

<a {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-md font-medium px-4 py-2 text-center text-sm focus:outline-none'.($disabled?' opacity-50 cursor-default':'')]) }}>
    {{ $slot }}
</a>