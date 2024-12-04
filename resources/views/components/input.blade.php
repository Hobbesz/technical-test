<label for="{{ $id }}" class="col-span-4">{{ $label }}</label>

<div class="col-span-6">
    <input
        id="{{ $id }}"
        type="{{ isset($type) ? $type : 'text' }}"
        class="shadow appearance-none border border-gray-200 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-400 @error($name) border-red-500 @enderror"
        name="{{ $name }}"
        value="{{ old($name) }}"
        @if(isset($required) && $required)required @endif
        autocomplete="{{ $name }}"
        @if(isset($autofocus) && $autofocus) autofocus @endif
    >

    @error($id)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>