@props(['name', 'id' => null, 'label', 'required' => false])

<div class="relative">
    <select id="{{ $id ?? $name }}" name="{{ $name }}"
        {{ $attributes->merge([
            'class' =>
                'block w-full px-4 py-3 text-sm text-gray-900 bg-transparent rounded-lg border ' .
                ($errors->has($name) ? 'border-red-500 focus:border-red-600' : 'border-gray-300 focus:border-sky-800') .
                ' appearance-none focus:outline-none focus:ring-0 peer',
        ]) }}
        {{ $required ? 'required' : '' }}>
        {{ $slot }}
    </select>
    <label for="{{ $id ?? $name }}"
        class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2
               peer-focus:px-2
               {{ $errors->has($name) ? 'text-red-600' : 'text-gray-500 peer-focus:text-sky-800' }}
               start-4">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
</div>
