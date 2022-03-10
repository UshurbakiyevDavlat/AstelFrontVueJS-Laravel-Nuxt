<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        
        <?php echo $__env->make('vendor.elfinder.common_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('vendor.elfinder.common_styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <script type="text/javascript">
            $().ready(function () {
                var elf = $('#elfinder').elfinder({
                    // set your elFinder options here
                    <?php if($locale): ?>
                        lang: '<?php echo e($locale); ?>', // locale
                    <?php endif; ?>
                    customData: { 
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    url: '<?php echo e(route("elfinder.connector")); ?>',  // connector URL
                    soundPath: '<?php echo e(asset($dir.'/sounds')); ?>',
                    dialog: {width: 900, modal: true, title: 'Select a file'},
                    resizable: false,
                    onlyMimes: <?php echo json_encode(unserialize(urldecode(request('mimes'))), 15, 512) ?>,
                    commandsOptions: {
                        getfile: {
                            multiple: <?php echo e(request('multiple') ? 'true' : 'false'); ?>,
                            oncomplete: 'destroy'
                        }
                    },
                    getFileCallback: function (file) {
                        <?php if(request()->has('multiple') && request()->input('multiple') == 1): ?>
                            window.parent.processSelectedMultipleFiles(file, '<?php echo e($input_id); ?>');
                        <?php else: ?>
                            window.parent.processSelectedFile(file.path, '<?php echo e($input_id); ?>');
                        <?php endif; ?>

                        parent.jQuery.colorbox.close();
                    }
                }).elfinder('instance');
            });
        </script>

    </head>
    <body>

        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>

    </body>
</html>
<?php /**PATH C:\Users\dushu\Desktop\AstelKz\admin\resources\views/vendor/elfinder/standalonepopup.blade.php ENDPATH**/ ?>