@props([
    'type' => 'text',
    'name',
    'id' => null,
    'value' => '',
    'label',
    'required' => false,
])

<div class="relative">
    <input type="{{ $type }}" id="{{ $id ?? $name }}" name="{{ $name }}" value="{{ $value }}"
        placeholder=" " {{-- Wajib ada untuk memicu :placeholder-shown --}}
        {{ $attributes->merge([
            'class' =>
                'block w-full px-4 py-3 text-sm text-gray-900 bg-transparent rounded-lg border ' .
                ($errors->has($name) ? 'border-red-500 focus:border-red-600' : 'border-gray-300 focus:border-sky-800') .
                ' appearance-none focus:outline-none focus:ring-0 peer',
        ]) }}
        {{ $required ? 'required' : '' }} />
    <label for="{{ $id ?? $name }}"
        class="absolute text-sm duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2
               peer-focus:px-2
               {{ $errors->has($name) ? 'text-red-600' : 'text-gray-500 peer-focus:text-sky-800' }}
               peer-placeholder-shown:scale-100
               peer-placeholder-shown:-translate-y-1/2
               peer-placeholder-shown:top-1/2
               peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4
               start-4">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
</div>
