@props(['disabled' => false, 'checked' => false])

<input @checked($checked) type="checkbox" {{ $attributes->class(["w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2", 'opacity-50 cursor-default' => $disabled]) }}>