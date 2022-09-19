@props(['items', 'selected'])


<select {{ $attributes->merge(['class' => 'w-full']) }}>
    <option value="">@lang('Выберите значение')</option>

    @foreach($items as $item)
        <option value="{{ data_get($item, 'value') }}" {{ in_array(data_get($item, 'value'), is_array($selected) ? $selected : [$selected]) ? 'selected' : ''}}>
            {{ data_get($item, 'title') }}
        </option>
    @endforeach
</select>
