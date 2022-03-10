<?php
$values = data_get($entry, $column['name']);

if (!is_array($values)) {
    $values = [$values];
}
$values = array_filter($values);
?>
<?php if(count($values) == 0): ?>
    <span>
        -
    </span>
<?php else: ?>
    <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $column['height'] = $column['height'] ?? "25px";
            $column['width'] = $column['width'] ?? "auto";
            $column['radius'] = $column['radius'] ?? "3px";
            $column['prefix'] = $column['prefix'] ?? '';

            if (is_array($value)) {
                $value = json_encode($value);
            }

            if (preg_match('/^data\:image\//', $value)) { // base64_image
                $href = $src = $value;
            } elseif (isset($column['disk'])) { // image from a different disk (like s3 bucket)
                $href = $src = Storage::disk($column['disk'])->url($column['prefix'].$value);
            } else { // plain-old image, from a local disk
                $href = $src = asset( $column['prefix'] . $value);
            }

            $column['wrapper']['element'] = 'a';
            $column['wrapper']['href'] = $href;
            $column['wrapper']['target'] = '_blank';
        ?>

        <?php echo $__env->renderWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
            <img src="<?php echo e($src); ?>" style="
            padding: 6px;
            background-color: #C81920;
            max-height: <?php echo e($column['height']); ?>;
            width: <?php echo e($column['width']); ?>;
            border-radius: 80px;"
            />
        <?php echo $__env->renderWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endif; ?>
<?php /**PATH C:\Users\dushu\Desktop\AstelKz\admin\resources\views/vendor/backpack/crud/columns/icon.blade.php ENDPATH**/ ?>