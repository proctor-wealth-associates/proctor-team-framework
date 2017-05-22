
@if ($errors->has($name))
    <small class="helper">{{ $errors->first($name) }}</small>
@endif
