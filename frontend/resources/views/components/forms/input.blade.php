@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} 
    {{ $attributes->class(['bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand-purple-500 focus:border-brand-purple-500 focus:outline-none block w-full p-2.5']) }}
/>