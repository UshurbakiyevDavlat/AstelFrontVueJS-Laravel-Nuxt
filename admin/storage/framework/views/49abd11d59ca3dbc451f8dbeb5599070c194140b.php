<?php
$multiple = Arr::get($field, 'multiple', false);
$sortable = Arr::get($field, 'sortable', true);
$value = old(square_brackets_to_dots($field['name'])) ?? $field['value'] ?? $field['default'] ?? '';

if (!$multiple && is_array($value)) {
    $value = Arr::first($value);
}

$field['wrapper'] = $field['wrapperAttributes'] ?? [];
$field['wrapper']['data-init-function'] = $field['wrapper']['data-init-function'] ?? 'bpFieldInitBrowseMultipleElement';
$field['wrapper']['data-elfinder-trigger-url'] = $field['wrapper']['data-elfinder-trigger-url'] ?? url(config('elfinder.route.prefix').'/popup/'.$field['name'].'?multiple=1');

if (isset($field['mime_types'])) {
    $field['wrapper']['data-elfinder-trigger-url'] .= '&mimes='.urlencode(serialize($field['mime_types']));
}

if ($multiple) {
    $field['wrapper']['data-multiple'] = "true";
} else {
    $field['wrapper']['data-multiple'] = "false";
}

if($sortable){
    $field['wrapper']['sortable'] = "true";
}
if ($multiple && is_string($value)) {
    $value = json_decode($value);
}

?>

<?php echo $__env->make('crud::fields.inc.wrapper_start', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div><label><?php echo $field['label']; ?></label></div>
    <?php echo $__env->make('crud::fields.inc.translatable_icon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="list" data-field-name="<?php echo e($field['name']); ?>">
        <?php if($multiple): ?>
            <input type="hidden" data-marker="multipleBrowseInput" name="<?php echo e($field['name']); ?>" value="<?php echo e(json_encode($value)); ?>">
        <?php else: ?>
            <div class="input-group input-group-sm item">
                <div class="item-img" <?php if($value): ?> style='background-image: url("<?php echo e(Storage::disk("elfinder")->url($value)); ?>");' <?php endif; ?>></div>
                <input type="text" data-marker="multipleBrowseInput" name="<?php echo e($field['name']); ?>" value="<?php echo e($value); ?>" <?php echo $__env->make('crud::fields.inc.attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> readonly>
            </div>
        <?php endif; ?>
    </div>
    <div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">
        <button type="button" class="browse popup btn btn-sm btn-light">
            <i class="la la-cloud-upload"></i>
            <?php echo e(trans('backpack::crud.browse_uploads')); ?>

        </button>
        <button type="button" class="browse clear btn btn-sm btn-light">
            <i class="la la-eraser"></i>
            <?php echo e(trans('backpack::crud.clear')); ?>

        </button>
    </div>

    <?php if(isset($field['hint'])): ?>
        <p class="help-block"><?php echo $field['hint']; ?></p>
    <?php endif; ?>

    <script type="text/html" data-marker="browse_multiple_template">
        <div class="input-group input-group-sm item">
            <div class="item-img"></div>
            <input type="text" <?php echo $__env->make('crud::fields.inc.attributes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> readonly>
            <div class="input-group-btn">
                <button type="button" class="browse remove btn btn-sm btn-light">
                    <i class="la la-trash"></i>
                </button>
                <?php if($sortable): ?>
                    <button type="button" class="browse move btn btn-sm btn-light"><span class="la la-sort"></span></button>
                <?php endif; ?>
            </div>
        </div>
    </script>
<?php echo $__env->make('crud::fields.inc.wrapper_end', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>





<?php if($crud->fieldTypeNotLoaded($field)): ?>
    <?php
        $crud->markFieldTypeAsLoaded($field);
    ?>

    
    <?php $__env->startPush('crud_fields_styles'); ?>
        <link href="<?php echo e(asset('packages/jquery-colorbox/example2/colorbox.css')); ?>" rel="stylesheet" type="text/css" />
        <style>
            #cboxContent, #cboxLoadedContent, .cboxIframe {
                background: transparent;
            }
            .item-img {
                width: 150px;
                z-index: 2;
                background-position: center;
                background-size: cover;
            }
            .item {
                 height: 80px;
                 margin-bottom: 5px;
            }
            .item input {
                 height: 80px!important;
            }
            .item div {
                 height: 80px!important;
            }
            .item div button {
                 height: 80px!important;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('crud_fields_scripts'); ?>

        <script src="<?php echo e(asset('packages/jquery-ui-dist/jquery-ui.min.js')); ?>"></script>
        <script src="<?php echo e(asset('packages/jquery-colorbox/jquery.colorbox-min.js')); ?>"></script>
        <script>
            // this global variable is used to remember what input to update with the file path
            // because elfinder is actually loaded in an iframe by colorbox
            var elfinderTarget = false;

            // function to use the files selected inside elfinder
            function processSelectedMultipleFiles(files, requestingField) {
                elfinderTarget.trigger('createInputsForItemsSelectedWithElfinder', [files]);
                elfinderTarget = false;
            }

            function bpFieldInitBrowseMultipleElement(element) {
                var $triggerUrl = element.data('elfinder-trigger-url');
                var $template = element.find("[data-marker=browse_multiple_template]").html();
                var $list = element.find(".list");
                var $input = element.find('input[data-marker=multipleBrowseInput]');
                var $multiple = element.attr('data-multiple');
                var $sortable = element.attr('sortable');

                // show existing items - display visible inputs for each stored path
                if ($input.val() != '' && $input.val() != null && $multiple === 'true') {
                    $paths = JSON.parse($input.val());
                    if (Array.isArray($paths) && $paths.length) {
                        // remove any already visible inputs
                        $list.find('.input-group').remove();

                        // add visible inputs for each item inside the hidden input array
                        $paths.forEach(function (path) {
                            var newInput = $($template);
                            newInput.find('input').val(path);
                            newInput.find('.item-img').attr('style', `background-image: url("<?php echo e(Storage::disk('elfinder')->url('')); ?>${path}")`);
                            $list.append(newInput);
                        });
                    }
                } else if ($multiple !== 'true' && $input.val()) {
                    $list.find('.item-img').attr('style', `background-image: url("<?php echo e(Storage::disk('elfinder')->url('')); ?>${$input.val()}")`)
                }

                // make the items sortable, if configurations says so
                if($sortable){
                    $list.sortable({
                        handle: 'button.move',
                        cancel: '',
                        update: function (event, ui) {
                            element.trigger('saveToJson');
                        }
                    });
                }

                element.on('click', 'button.popup', function (event) {
                    event.preventDefault();

                    // remember which element the elFinder was triggered by
                    elfinderTarget = element;

                    // trigger the elFinder modal
                    $.colorbox({
                        href: $triggerUrl,
                        fastIframe: true,
                        iframe: true,
                        width: '80%',
                        height: '80%'
                    });
                });

                // turn non-hidden inputs into a JSON
                // and save them inside the hidden input that ACTUALLY holds all paths
                element.on('saveToJson', function(event) {
                    var $paths = element.find('input').not('[type=hidden]').map(function (idx, item) {
                        return $(item).val();
                    }).toArray();

                    // save the JSON inside the hidden input
                    $input.val(JSON.stringify($paths));
                });

                if ($multiple === 'true') {
                    // remote item button
                    element.on('click', 'button.remove', function (event) {
                        event.preventDefault();
                        $(this).closest('.input-group').remove();
                        element.trigger('saveToJson');
                    });

                    // clear button
                    element.on('click', 'button.clear', function (event) {
                        event.preventDefault();

                        $('.input-group', $list).remove();
                        element.trigger('saveToJson');
                    });

                    // called after one or more items are selected in the elFinder window
                    element.on('createInputsForItemsSelectedWithElfinder', element, function(event, files) {
                        files.forEach(function (file) {
                            var newInput = $($template);
                            let url = file.path;
                            newInput.find('input').val(url);
                            newInput.find('.item-img').attr('style', `background-image: url("<?php echo e(Storage::disk('elfinder')->url('')); ?>${url}")`);
                            $list.append(newInput);
                        });

                        if($sortable){
                            $list.sortable("refresh")
                        }

                        element.trigger('saveToJson');
                    });

                } else {
                    // clear button
                    element.on('click', 'button.clear', function (event) {
                        $input.val('');
                        $list.find('.item-img').attr('style', `background-image: unset`);
                    });

                    // called after an item has been selected in the elFinder window
                    element.on('createInputsForItemsSelectedWithElfinder', element, function(event, files) {
                        let url = files[0].path;
                        $list.find('.item-img').attr('style', `background-image: url("<?php echo e(Storage::disk('elfinder')->url('')); ?>${url}")`);
                        $input.val(url);
                    });
                }
            }
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>



<?php /**PATH C:\Users\dushu\Desktop\AstelKz\admin\resources\views/vendor/backpack/crud/fields/image.blade.php ENDPATH**/ ?>