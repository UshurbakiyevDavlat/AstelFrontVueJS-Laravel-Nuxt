@php
    $column['name'] = str_replace("->{$column['locale']}", '', $column['name']);
    $value = $entry->getTranslation($column['name'], $column['locale']);

@endphp

<div>
	<a href="{{ backpack_url('translation', ['id' => $entry->id]) }}/edit?locale={{ $column['locale'] }}"><small><i class="la la-edit"></i>{{ trans('admin.edit') }}</small></a>
	<div style="max-width: 400px; white-space: normal;">
		{{ (array_key_exists('prefix', $column) ? $column['prefix'] : '').Str::limit(strip_tags($value), array_key_exists('limit', $column) ? $column['limit'] : 40, "[...]").(array_key_exists('suffix', $column) ? $column['suffix'] : '') }}
	</div>
</div>
