
<div class="field{{ 
    $errors->has($name) ? ' error' : '' }}{{ 
    isset($fieldClass) ? " $fieldClass" : '' }}"
>

    {{ $slot }}
    
    @include('components.shared.form.error')
</div>
