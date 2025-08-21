<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>

    option {
        font-family: monospace; /* Ensures table-like appearance */
        white-space: pre; /* Preserves spaces and alignment */
    }
</style>
<div class="modal fade " id="TypeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= _l('qr_services') ?></h4>
            </div>

            <form id="recyclingForm">
                <input type="hidden" name="label_id" id="label_id" value="<?= isset($id) ? $id : 0 ?>">
                <input type="hidden" name="label_bottle" id="label_bottle" value="<?= isset($recycling) ? $recycling->bottle_id : 0 ?>">
                <input type="hidden" name="label_cork" id="label_cork" value="<?= isset($recycling) ? $recycling->cork_id : 0 ?>">
                <input type="hidden" name="label_capsule" id="label_capsule" value="<?= isset($recycling) ? $recycling->capsule_id : 0 ?>">
                <input type="hidden" name="label_cage" id="label_cage" value="<?= isset($recycling) ? $recycling->cork_cage_id : 0 ?>">
                <input type="hidden" name="label_container" id="label_container" value="<?= isset($recycling) ? $recycling->packaging_id : 0 ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                       value="<?= $this->security->get_csrf_hash() ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <div id="label_bottle_types" style="display:none;">
                                <?php $list_bottle = isset($producer) ? $producer : [];
                                ?>
                                <div class=" form-group">
                                    <label for="type"><?php echo _l('qr_producer'); ?></label>
                                    <select name="producer_id" id="producer_id"
                                            class="form-control" data-width="100%"
                                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>"
                                            data-hide-disabled="true">
                                        <option value=""><?php echo _l('dropdown_non_selected_tex'); ?></option>
                                        <?php
                                        // echo json_encode($list_bottle);die;
                                        foreach ($list_bottle as $data) {
                                            ?>
                                            <option value="<?= $data['id'] ?>" <?php if (isset($recycling) && $recycling->producer_id === $data['id']) {
                                                echo 'selected';
                                            } ?>> <?= $data['name'] ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div id="label_cork_types">
                                <?php $list_printing = isset($printing) ? $printing : [];
                                ?>
                                <div class=" form-group">
                                    <label for="type"><?php echo _l('qr_printing'); ?></label>
                                    <select name="printing_id" id="printing_id"
                                            class="form-control" data-width="100%"
                                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>"
                                            data-hide-disabled="true">
                                        <option value=""><?php echo _l('dropdown_non_selected_tex'); ?></option>
                                        <?php
                                        foreach ($list_printing as $data) {
                                            ?>
                                            <option value="<?= $data['id'] ?>" <?php if (isset($recycling) && $recycling->printing_id === $data['id']) {
                                                echo 'selected';
                                            } ?>> <?= $data['name']  ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div id="label_capsule_types">
                                <?php $list_oenology = isset($oenology) ? $oenology : [];
                                ?>
                                <div class=" form-group">
                                    <label for="type"><?php echo _l('qr_oenology'); ?></label>
                                    <select name="oenology_id" id="oenology_id"
                                            class="form-control" data-width="100%"
                                            data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>"
                                            data-hide-disabled="true">
                                        <option value=""><?php echo _l('dropdown_non_selected_tex'); ?></option>
                                        <?php
                                        foreach ($list_oenology as $data) {
                                            ?>
                                            <option value="<?= $data['id'] ?>" <?php if (isset($recycling) && $recycling->oenology_id === $data['id']) {
                                                echo 'selected';
                                            } ?>> <?= $data['name']  ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= _l('qr_close') ?></button>
                    <button type="submit" class="btn btn-primary"><?= _l('qr_save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $('#recyclingForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: admin_url + '<?= QR_labels ?>/add_type',
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
                    "<?= $this->security->get_csrf_token_name() ?>": "<?= $this->security->get_csrf_hash() ?>"
                },
            success: function (data) {
                $('#TypeModal').modal('hide');
                alert_float(data.alert, data.message);
                // $('.table-template_module').DataTable().ajax.reload();
                window.location.reload();
            }
        });
    });
</script>
