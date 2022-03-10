{{-- regular object attribute --}}
@php
    $column['escaped'] = $column['escaped'] ?? true;
    $column['decimals'] = $column['decimals'] ?? 0;
    $column['dec_point'] = $column['dec_point'] ?? '.';
    $column['thousands_sep'] = $column['thousands_sep'] ?? ',';
    $column['prefix'] = $column['prefix'] ?? '';
    $column['suffix'] = $column['suffix'] ?? '';

    $value = data_get($entry, $column['name']);
    if (!is_null($value)) {
    	$value = number_format($value, $column['decimals'], $column['dec_point'], $column['thousands_sep']);
    }
    $column['text'] = is_null($value) ? '-' : $column['prefix'].$value.$column['suffix'];
@endphp

<span>
	@includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        @if($column['escaped'])
            {{ $column['text'] }}
        @else
            {!! $column['text'] !!}
        @endif
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>
