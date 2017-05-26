
@foreach (session('flash_notification') as $message)
    <div class="ui {{ $message->level }} message" role="alert" {!! isset($style) ? "style=\"$style\"" : '' !!}>
        @if ($message->closable)
            <i class="close icon"></i>
        @endif

        @if ($message->title)
            <div class="header">
                {!! $message->title !!}
            </div>
        @endif

        {!! $message->message !!}
    </div>
@endforeach

{{ session()->forget('flash_notification') }}
