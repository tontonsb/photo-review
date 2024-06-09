
<code>
    @foreach ($exif as $key => $value)
        @if (is_scalar($value) || is_null($value))
            {{$key}}: {{$value}}
        @elseif (is_array($value))
            @foreach ($value as $subkey => $subvalue)
                {{$key}} {{$subkey}}: {{is_string($subvalue) ? $subvalue : json_encode($subvalue)}}
            @endforeach
        @endif
    @endforeach
</code>
