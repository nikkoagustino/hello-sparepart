<select name="{{ $name ?? 'year' }}" class="form-control form-select">
    <option value="" selected="selected" disabled="disabled"></option>
    @for ($i = config('user.MIN_YEAR'); $i <= date('Y'); $i++)
        <option value="{{ $i }}">{{ $i }}</option>
    @endfor
</select>