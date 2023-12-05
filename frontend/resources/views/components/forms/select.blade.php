@props(['disabled' => false, 'selected' => false])

<select {{ $disabled? 'disabled': ''}} @selected($disabled) {{ $attributes->class(['bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg capitalize focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5', '!bg-gray-100 !cursor-default' => $disabled]) }}>{{ $slot }}</select>