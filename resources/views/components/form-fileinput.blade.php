@props([
    'name',
    'label',
    'id' => $name,
    'accept' => 'image/png,image/jpeg',
    'required' => false,
])

<div class="space-y-1">
    <label for="{{ $id }}" class="block text-xs font-semibold">{{ $label }}@if($required)<span class="ml-1" aria-hidden="true">*</span>@endif</label>
    <input type="file" id="{{ $id }}" name="{{ $name }}" accept="{{ $accept }}" class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium hover:file:bg-gray-200 {{ $errors->has($name) ? 'rounded-md border border-red-500' : '' }}" @required($required)>
    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
