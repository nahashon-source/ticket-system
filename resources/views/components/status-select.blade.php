<select name="status_id" class="form-select w-auto">
    @foreach($statuses as $status)
        <option value="{{ $status->id }}" {{ $selected == $status->id ? 'selected' : '' }}>
            {{ $status->name }}
        </option>
    @endforeach
</select>
