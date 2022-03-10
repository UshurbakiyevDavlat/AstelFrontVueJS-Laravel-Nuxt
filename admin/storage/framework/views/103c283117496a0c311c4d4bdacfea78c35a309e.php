<?php
    $column['text'] = Illuminate\Mail\Markdown::parse($entry->{$column['name']} ?? '');
    $column['escaped'] = $column['escaped'] ?? false;
    $column['prefix'] = $column['prefix'] ?? '';
    $column['suffix'] = $column['suffix'] ?? '';

    if(!empty($column['text'])) {
        $column['text'] = $column['prefix'].$column['text'].$column['suffix'];
    }
?>

<?php echo $__env->renderWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
    <?php if($column['escaped']): ?>
        <?php echo e($column['text']); ?>

    <?php else: ?>
        <?php echo $column['text']; ?>

    <?php endif; ?>
<?php echo $__env->renderWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>

<?php /**PATH C:\Users\dushu\Desktop\AstelKz\admin\vendor\backpack\crud\src\resources\views\crud/columns/markdown.blade.php ENDPATH**/ ?>