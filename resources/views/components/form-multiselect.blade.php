@props([
    'name',
    'label',
    'options' => [],
    'value' => [],
    'id' => $name,
    'placeholder' => 'Choose one or more',
])

@php
    // after a validation error, keep what the user ticked; otherwise show the saved values
    $selectedValues = array_map('strval', (array) old($name, $value));
@endphp

<div class="space-y-1">
    <p class="block text-xs font-semibold">{{ $label }}</p>

    {{-- <details> is a plain HTML dropdown: closed it shows only the <summary> line, no JavaScript needed --}}
    <details id="{{ $id }}" class="rounded-md border shadow-2xs {{ $errors->has($name) ? 'border-red-500' : 'border-gray-400' }}">
        <summary class="cursor-pointer px-3 py-2">{{ $placeholder }}</summary>

        <div class="max-h-60 space-y-2 overflow-y-auto border-t border-gray-200 px-3 py-2">
            @foreach($options as $option)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="{{ $name }}[]" value="{{ $option['key'] }}" @checked(in_array((string) $option['key'], $selectedValues, true))>
                    {{ $option['value'] }}
                </label>
            @endforeach
        </div>
    </details>

    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
