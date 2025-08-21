<div class="modal fade" id="nutritionModal" tabindex="-1" role="dialog" aria-labelledby="nutritionModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="nutritionModalLabel">
                    <i class="fa fa-info-circle"></i> <?php echo _l('nutrition_facts'); ?>
                </h4>
            </div>
            <form id="nutritionForm" method="post" action="<?php echo admin_url('qrwine/add_nutrition'); ?>">
                <div class="modal-body">
                    <!-- Updated field names to match controller add_nutrition method -->
                    <input type="hidden" id="id_label_nutrition" name="id_label_nutrition" value="">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kcal_input"><?php echo _l('kcal'); ?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="kcal_input" name="kcal_input" step="0.01">
                                    <span class="input-group-addon">Kcal</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kj_input"><?php echo _l('kj'); ?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="kj_input" name="kj_input" step="0.01">
                                    <span class="input-group-addon">Kj</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="grassi_input"><?php echo _l('fat'); ?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="grassi_input" name="grassi_input" step="0.01">
                                    <span class="input-group-addon">g</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saturi_input"><?php echo _l('saturated_fat'); ?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="saturi_input" name="saturi_input" step="0.01">
                                    <span class="input-group-addon">g</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="carboidrati"><?php echo _l('carbohydrates'); ?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="carboidrati" name="carboidrati" step="0.01">
                                    <span class="input-group-addon">g</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="zuccheri"><?php echo _l('sugars'); ?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="zuccheri" name="zuccheri" step="0.01">
                                    <span class="input-group-addon">g</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proteine"><?php echo _l('protein'); ?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="proteine" name="proteine" step="0.01">
                                    <span class="input-group-addon">g</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sale_input"><?php echo _l('salt'); ?></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="sale_input" name="sale_input" step="0.01">
                                    <span class="input-group-addon">g</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="ingredient"><?php echo _l('ingredient_normal'); ?></label>
                        <input type="text" class="form-control" id="ingredient" name="ingredient">
                    </div>
                    
                    <div class="form-group">
                        <label for="preservatives"><?php echo _l('preservatives_antioxidants'); ?></label>
                        <textarea class="form-control" id="preservatives" name="preservatives" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo _l('save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#nutritionForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.alert === 'success') {
                    alert_float('success', response.message);
                    $('#nutritionModal').modal('hide');
                } else {
                    alert_float('danger', response.message);
                }
            },
            error: function() {
                alert_float('danger', 'An error occurred while saving nutrition data.');
            }
        });
    });
});
</script>
