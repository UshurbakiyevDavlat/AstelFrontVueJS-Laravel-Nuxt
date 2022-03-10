
<?php
    $checkValue = data_get($entry, $column['name']);

    $checkedIcon = data_get($column, 'icons.checked', 'la-check-circle');
    $uncheckedIcon = data_get($column, 'icons.unchecked', 'la-circle');

    $exportCheckedText = data_get($column, 'labels.checked', trans('backpack::crud.yes'));
    $exportUncheckedText = data_get($column, 'labels.unchecked', trans('backpack::crud.no'));

    $icon = $checkValue == false ? $uncheckedIcon : $checkedIcon;

    $column['text'] = $checkValue == false ? $exportUncheckedText : $exportCheckedText;
    $column['escaped'] = $column['escaped'] ?? true;
    $column['prefix'] = $column['prefix'] ?? '';
    $column['suffix'] = $column['suffix'] ?? '';
    
    $column['text'] = $column['prefix'].$column['text'].$column['suffix'];
?>

<span>
    <?php echo $__env->renderWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
    <i class="la <?php echo e($icon); ?>"></i>
    <?php echo $__env->renderWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
</span>

<span class="sr-only">
    <?php if($column['escaped']): ?>
        <?php echo e($column['text']); ?>

    <?php else: ?>
        <?php echo $column['text']; ?>

    <?php endif; ?>
</span>
<?php /**PATH C:\Users\dushu\Desktop\AstelKz\admin\vendor\backpack\crud\src\resources\views\crud/columns/check.blade.php ENDPATH**/ ?>