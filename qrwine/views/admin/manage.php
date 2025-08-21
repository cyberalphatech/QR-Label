<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo _l('wine_labels_management'); ?></h3>
                <div class="panel-actions">
                    <a href="<?php echo admin_url('qrwine/wine_label'); ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> <?php echo _l('new_wine_label'); ?>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <?php render_datatable([
                    _l('wine_name'),
                    _l('producer'),
                    _l('vintage'),
                    _l('alcohol_content'),
                    _l('status'),
                    _l('created_date'),
                    _l('options')
                ], 'wine-labels'); ?>
            </div>
        </div>
    </div>
</div>
