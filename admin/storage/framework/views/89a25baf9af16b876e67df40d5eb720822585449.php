<?php
    $column['name'] = str_replace("->{$column['locale']}", '', $column['name']);
    $value = $entry->getTranslation($column['name'], $column['locale']);

?>

<div>
	<a href="<?php echo e(backpack_url('translation', ['id' => $entry->id])); ?>/edit?locale=<?php echo e($column['locale']); ?>"><small><i class="la la-edit"></i><?php echo e(trans('admin.edit')); ?></small></a>
	<div style="max-width: 400px; white-space: normal;">
		<?php echo e((array_key_exists('prefix', $column) ? $column['prefix'] : '').Str::limit(strip_tags($value), array_key_exists('limit', $column) ? $column['limit'] : 40, "[...]").(array_key_exists('suffix', $column) ? $column['suffix'] : '')); ?>

	</div>
</div>
<?php /**PATH C:\Users\dushu\Desktop\AstelKz\admin\resources\views/vendor/backpack/crud/columns/translation.blade.php ENDPATH**/ ?>