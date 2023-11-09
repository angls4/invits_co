@props(['disabled' => false])

<textarea @disabled($disabled) {{ $attributes->class(["block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-brand-purple-500 focus:border-brand-purple-500", 'opacity-50 cursor-default' => $disabled]) }}>{{ $slot }}</textarea>