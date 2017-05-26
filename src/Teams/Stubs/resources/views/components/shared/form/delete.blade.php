
<form 
    style="display: inline-block;" 
    action="{{ $action }}" 
    method="POST"
>
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    {{ $slot }}
</form>
