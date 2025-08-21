<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade " id="certificationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">CERTIFICATIONS</h4>
            </div>

            <form id="certificationForm">
                <input type="hidden" name="label_id_certification" id="label_id_certification"
                       value="<?= isset($id) ? $id : 0 ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                       value="<?= $this->security->get_csrf_hash() ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" style="text-align: center; font-size: 20px; font-weight: bold">
                            ITALIAN CERTIFICATIONS
                        </div>
                        <div class="col-md-12 mt-2" style="margin-top: 20px">
                            <div class="col-md-4">
                                <label for="cert_i_1">
                                    <img src="<?= base_url() . 'modules/qr_labels/upload/certificate/doc.png' ?>" alt="" style="width: 100%">
                                </label>
                                <input type="checkbox" name="cert_i_1" id="cert_i_1" value="1" style="width: 100%; height: 20px"
                                    <?php if(isset($label) && $label->cert_i_1 == 1){echo 'checked';} ?>>
                            </div>
                            <div class="col-md-4">
                                <label for="cert_i_2">
                                    <img src="<?= base_url() . 'modules/qr_labels/upload/certificate/docg.png' ?>" alt="" style="width: 100%">
                                </label>
                                <input type="checkbox" name="cert_i_2" id="cert_i_2" value="1" style="width: 100%; height: 20px"  <?php if(isset($label) && $label->cert_i_2 == 1){echo 'checked';} ?>>
                            </div>
                            <div class="col-md-4">
                                <label for="cert_i_3">
                                    <img src="<?= base_url() . 'modules/qr_labels/upload/certificate/igt.png' ?>" alt="" style="width: 100%">
                                </label>
                                <input type="checkbox" name="cert_i_3" id="cert_i_3" value="1" style="width: 100%; height: 20px"  <?php if(isset($label) && $label->cert_i_3 == 1){echo 'checked';} ?>>
                            </div>
                        </div>

                        <div class="col-md-12" style="text-align: center; font-size: 20px; font-weight: bold; margin-top: 20px">
                            EUROPEAN CERTIFICATIONS
                        </div>
                        <div class="col-md-12 mt-2" style="margin-top: 20px">
                            <div class="col-md-4">
                                <label for="cert_eu_1">
                                    <img src="<?= base_url() . 'modules/qr_labels/upload/certificate/eu_dop.png' ?>" alt="" style="width: 100%">
                                </label>
                                <input type="checkbox" name="cert_eu_1" id="cert_eu_1" value="1" style="width: 100%; height: 20px" <?php if(isset($label) && $label->cert_eu_1 == 1){echo 'checked';} ?>>
                            </div>
                            <div class="col-md-4">
                                <label for="cert_eu_2">
                                    <img src="<?= base_url() . 'modules/qr_labels/upload/certificate/eu_stg.png' ?>" alt="" style="width: 100%">
                                </label>
                                <input type="checkbox" name="cert_eu_2" id="cert_eu_2" value="1" style="width: 100%; height: 20px" <?php if(isset($label) && $label->cert_eu_2 == 1){echo 'checked';} ?>>
                            </div>
                            <div class="col-md-4">
                                <label for="cert_eu_3">
                                    <img src="<?= base_url() . 'modules/qr_labels/upload/certificate/eu_igp.png' ?>" alt="" style="width: 100%">
                                </label>
                                <input type="checkbox" name="cert_eu_3" id="cert_eu_3" value="1" style="width: 100%; height: 20px" <?php if(isset($label) && $label->cert_eu_3 == 1){echo 'checked';} ?>>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    init_tags_inputs();
    $('#certificationForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: admin_url + '<?= QR_labels ?>/add_certification',
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: "json",
            headers: {
                    "<?= $this->security->get_csrf_token_name() ?>": "<?= $this->security->get_csrf_hash() ?>"
                },
            success: function (data) {
                $('#certificationModal').modal('hide');
                alert_float(data.alert, data.message);
            }
        });
    });
</script>
