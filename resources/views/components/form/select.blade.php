@props(['name', 'label', 'options' => [], 'selected' => null, 'required' => false])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}{{ $required ? ' *' : '' }}</label>
    <select 
        name="{{ $name }}" 
        id="{{ $name }}" 
        class="form-select @error($name) is-invalid @enderror" 
        {{ $required ? 'required' : '' }}>
        <option value="" disabled {{ $selected ? '' : 'selected' }}>Select {{ strtolower($label) }}</option>
        @foreach ($options as $key => $value)
            @php $optionValue = is_int($key) ? $value : $key; @endphp
            <option value="{{ $optionValue }}" {{ $selected == $optionValue ? 'selected' : '' }}>
                {{ ucfirst($value) }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
