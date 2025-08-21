<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade " id="IngredientModal" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= _l('qr_ingre'); ?></h4>
            </div>

            <form id="IngredientForm">
                <input type="hidden" name="label_id_ingredient" id="label_id_ingredient"
                       value="<?= isset($id) ? $id : 0 ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                       value="<?= $this->security->get_csrf_hash() ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" id="ingredients_label">
                                <label for=""><?= _l('qr_ingredient_normal'); ?></label>
                                <input type="text" class="tagsinput" id="ingredients" name="ingredients"
                                       value="<?php echo(isset($id) ? prep_tags_input(get_tags_in($id, 'ingredients')) : ''); ?>"
                                       data-role="tagsinput">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=""><?= _l('qr_preseravatives'); ?></label>
                                <input type="text" class="tagsinput" id="preservatives" name="preservatives"
                                       value="<?php echo(isset($id) ? prep_tags_input(get_tags_in($id, 'preservatives')) : ''); ?>"
                                       data-role="tagsinput">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= _l('qr_close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?= _l('qr_save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    init_tags_inputs();
    $('#IngredientForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: admin_url + '<?= QR_labels ?>/add_ingredient',
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
                    "<?= $this->security->get_csrf_token_name() ?>": "<?= $this->security->get_csrf_hash() ?>"
                },
            success: function (data) {
                $('#IngredientModal').modal('hide');
                alert_float(data.alert, data.message);
            }
        });
    });
</script>
