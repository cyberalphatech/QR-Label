<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo form_open_multipart(admin_url('qrwine/wine_label' . (isset($wine_label) ? '/' . $wine_label->label_id : '')), ['id' => 'wine-label-form']); ?>
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="customer-profile-group-heading">
                                    <i class="fa fa-wine-bottle text-primary"></i> 
                                    <?php echo isset($wine_label) ? _l('edit_wine_label') : _l('new_wine_label'); ?>
                                </h4>
                                <hr class="hr-panel-heading">
                            </div>
                        </div>

                        <!-- Enhanced form with proper Perfex CRM styling and additional fields -->
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('name', 'wine_name', isset($wine_label) ? $wine_label->name : '', 'text', ['required' => true]); ?>
                                <?php echo render_input('grapev', 'grape_variety', isset($wine_label) ? $wine_label->grapev : ''); ?>
                                <?php echo render_input('vintage', 'vintage_year', isset($wine_label) ? $wine_label->vintage : '', 'number', ['min' => '1900', 'max' => date('Y')]); ?>
                                <?php echo render_input('alcohol', 'alcohol_content', isset($wine_label) ? $wine_label->alcohol : '', 'number', ['step' => '0.1', 'min' => '0', 'max' => '50']); ?>
                                
                                <!-- Added bottle size dropdown -->
                                <div class="form-group">
                                    <label for="BottleSize" class="control-label"><?php echo _l('bottle_size'); ?></label>
                                    <select name="BottleSize" id="BottleSize" class="form-control selectpicker" data-none-selected-text="<?php echo _l('select_bottle_size'); ?>">
                                        <option value=""><?php echo _l('select_bottle_size'); ?></option>
                                        <?php if(isset($bottle_sizes)): ?>
                                            <?php foreach($bottle_sizes as $bottle): ?>
                                                <option value="<?php echo $bottle->id; ?>" <?php echo (isset($wine_label) && $wine_label->BottleSize == $bottle->id) ? 'selected' : ''; ?>>
                                                    <?php echo $bottle->name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <!-- Added producer dropdown -->
                                <div class="form-group">
                                    <label for="ID_producer" class="control-label"><?php echo _l('producer'); ?></label>
                                    <select name="ID_producer" id="ID_producer" class="form-control selectpicker" data-none-selected-text="<?php echo _l('select_producer'); ?>">
                                        <option value=""><?php echo _l('select_producer'); ?></option>
                                        <?php if(isset($producers)): ?>
                                            <?php foreach($producers as $producer): ?>
                                                <option value="<?php echo $producer->id; ?>" <?php echo (isset($wine_label) && $wine_label->ID_producer == $producer->id) ? 'selected' : ''; ?>>
                                                    <?php echo $producer->name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('lot', 'lot_number', isset($wine_label) ? $wine_label->lot : '', 'text', ['required' => true]); ?>
                                <?php echo render_input('serving', 'serving_temperature', isset($wine_label) ? $wine_label->serving : '', 'number', ['min' => '0', 'max' => '30']); ?>
                                
                                <!-- Added wine characteristics fields -->
                                <?php echo render_input('Tcolor', 'wine_color', isset($wine_label) ? $wine_label->Tcolor : ''); ?>
                                <?php echo render_input('Ttaste', 'wine_taste', isset($wine_label) ? $wine_label->Ttaste : ''); ?>
                                <?php echo render_input('Tpairing', 'food_pairing', isset($wine_label) ? $wine_label->Tpairing : ''); ?>
                                
                                <!-- Added status dropdown -->
                                <div class="form-group">
                                    <label for="status" class="control-label"><?php echo _l('status'); ?></label>
                                    <select name="status" id="status" class="form-control selectpicker">
                                        <option value="draft" <?php echo (isset($wine_label) && $wine_label->status == 'draft') ? 'selected' : ''; ?>><?php echo _l('draft'); ?></option>
                                        <option value="published" <?php echo (isset($wine_label) && $wine_label->status == 'published') ? 'selected' : ''; ?>><?php echo _l('published'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?php echo render_textarea('description', 'description', isset($wine_label) ? $wine_label->description : '', ['rows' => 4]); ?>
                                <?php echo render_textarea('characteristics', 'wine_characteristics', isset($wine_label) ? $wine_label->characteristics : '', ['rows' => 3]); ?>
                            </div>
                        </div>

                        <!-- Added image upload section -->
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="bold"><?php echo _l('wine_images'); ?></h5>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Pic1" class="control-label"><?php echo _l('primary_image'); ?></label>
                                    <input type="file" name="Pic1" id="Pic1" class="form-control" accept="image/*">
                                    <?php if(isset($wine_label) && !empty($wine_label->Pic1)): ?>
                                        <div class="mtop10">
                                            <img src="<?php echo QRURL.'store/'.$wine_label->Pic1; ?>" class="img-responsive" style="max-width: 150px;">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Pic2" class="control-label"><?php echo _l('secondary_image'); ?></label>
                                    <input type="file" name="Pic2" id="Pic2" class="form-control" accept="image/*">
                                    <?php if(isset($wine_label) && !empty($wine_label->Pic2)): ?>
                                        <div class="mtop10">
                                            <img src="<?php echo QRURL.'store/'.$wine_label->Pic2; ?>" class="img-responsive" style="max-width: 150px;">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Pic3" class="control-label"><?php echo _l('tertiary_image'); ?></label>
                                    <input type="file" name="Pic3" id="Pic3" class="form-control" accept="image/*">
                                    <?php if(isset($wine_label) && !empty($wine_label->Pic3)): ?>
                                        <div class="mtop10">
                                            <img src="<?php echo QRURL.'store/'.$wine_label->Pic3; ?>" class="img-responsive" style="max-width: 150px;">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-bottom-toolbar text-right">
                                    <button type="submit" class="btn btn-primary"><?php echo _l('save'); ?></button>
                                    <a href="<?php echo admin_url('qrwine'); ?>" class="btn btn-default"><?php echo _l('cancel'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize selectpicker
    $('.selectpicker').selectpicker();
    
    // Form validation
    $('#wine-label-form').on('submit', function(e) {
        var name = $('input[name="name"]').val();
        var lot = $('input[name="lot"]').val();
        
        if(!name || !lot) {
            alert('<?php echo _l("wine_name_and_lot_required"); ?>');
            e.preventDefault();
            return false;
        }
    });
});
</script>

<?php init_tail(); ?>
</div>
</body>
</html>
