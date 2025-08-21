<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="customer-profile-group-heading">
                                    <i class="fa fa-wine-bottle text-primary"></i> 
                                    <?php echo _l('qr_wine_dashboard'); ?>
                                </h4>
                                <hr class="hr-panel-heading">
                            </div>
                        </div>

                        <!-- Redesigned statistics cards with Perfex CRM styling -->
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="tw-bg-primary-600 tw-text-white tw-p-5 tw-rounded-lg tw-shadow-sm">
                                    <div class="tw-flex tw-items-center tw-justify-between">
                                        <div>
                                            <p class="tw-text-primary-100 tw-text-sm tw-font-medium"><?php echo _l('total_wine_labels'); ?></p>
                                            <p class="tw-text-2xl tw-font-bold"><?php echo $total_labels; ?></p>
                                        </div>
                                        <div class="tw-bg-primary-500 tw-p-3 tw-rounded-full">
                                            <i class="fa fa-wine-bottle fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="tw-bg-success-600 tw-text-white tw-p-5 tw-rounded-lg tw-shadow-sm">
                                    <div class="tw-flex tw-items-center tw-justify-between">
                                        <div>
                                            <p class="tw-text-success-100 tw-text-sm tw-font-medium"><?php echo _l('published_labels'); ?></p>
                                            <p class="tw-text-2xl tw-font-bold"><?php echo $published_labels; ?></p>
                                        </div>
                                        <div class="tw-bg-success-500 tw-p-3 tw-rounded-full">
                                            <i class="fa fa-check-circle fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="tw-bg-warning-600 tw-text-white tw-p-5 tw-rounded-lg tw-shadow-sm">
                                    <div class="tw-flex tw-items-center tw-justify-between">
                                        <div>
                                            <p class="tw-text-warning-100 tw-text-sm tw-font-medium"><?php echo _l('draft_labels'); ?></p>
                                            <p class="tw-text-2xl tw-font-bold"><?php echo $draft_labels; ?></p>
                                        </div>
                                        <div class="tw-bg-warning-500 tw-p-3 tw-rounded-full">
                                            <i class="fa fa-edit fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="tw-bg-info-600 tw-text-white tw-p-5 tw-rounded-lg tw-shadow-sm">
                                    <div class="tw-flex tw-items-center tw-justify-between">
                                        <div>
                                            <p class="tw-text-info-100 tw-text-sm tw-font-medium"><?php echo _l('qr_codes_generated'); ?></p>
                                            <p class="tw-text-2xl tw-font-bold"><?php echo $qr_codes_generated; ?></p>
                                        </div>
                                        <div class="tw-bg-info-500 tw-p-3 tw-rounded-full">
                                            <i class="fa fa-qrcode fa-3x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Redesigned wine labels list with proper Perfex CRM table styling -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="customer-profile-group-heading">
                                    <i class="fa fa-list text-success"></i> 
                                    <?php echo _l('wine_labels_list'); ?>
                                </h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="<?php echo admin_url('qrwine/wine_label'); ?>" class="btn btn-info">
                                    <i class="fa fa-plus"></i> <?php echo _l('add_new_wine_label'); ?>
                                </a>
                            </div>
                        </div>
                        <hr class="hr-panel-heading">

                        <!-- Improved search and filter bar -->
                        <div class="row mbot15">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="search_labels" 
                                           placeholder="<?php echo _l('search_wine_labels'); ?>" 
                                           value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" id="btn_search">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control selectpicker" id="filter_status" data-none-selected-text="<?php echo _l('all_statuses'); ?>">
                                    <option value=""><?php echo _l('all_statuses'); ?></option>
                                    <option value="published" <?php echo (isset($_GET['status']) && $_GET['status'] == 'published') ? 'selected' : ''; ?>><?php echo _l('published'); ?></option>
                                    <option value="draft" <?php echo (isset($_GET['status']) && $_GET['status'] == 'draft') ? 'selected' : ''; ?>><?php echo _l('draft'); ?></option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control selectpicker" id="filter_producer" data-none-selected-text="<?php echo _l('all_producers'); ?>">
                                    <option value=""><?php echo _l('all_producers'); ?></option>
                                    <?php if(isset($producers)): ?>
                                        <?php foreach($producers as $producer): ?>
                                            <option value="<?php echo $producer->id; ?>" <?php echo (isset($_GET['producer']) && $_GET['producer'] == $producer->id) ? 'selected' : ''; ?>>
                                                <?php echo $producer->name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Professional wine labels table with Perfex CRM styling -->
                        <div class="table-responsive">
                            <table class="table dt-table" id="wine_labels_table">
                                <thead>
                                    <tr>
                                        <!-- Added id and label_id columns to table header -->
                                        <th width="50"><?php echo _l('id'); ?></th>
                                        <th width="80"><?php echo _l('label_id'); ?></th>
                                        <th width="50"><?php echo _l('image'); ?></th>
                                        <th><?php echo _l('wine_name'); ?></th>
                                        <th><?php echo _l('producer'); ?></th>
                                        <th><?php echo _l('vintage'); ?></th>
                                        <th><?php echo _l('bottle'); ?></th>
                                        <th><?php echo _l('alcohol_percentage'); ?></th>
                                        <th><?php echo _l('lot_number'); ?></th>
                                        <th><?php echo _l('status'); ?></th>
                                        <th><?php echo _l('created_date'); ?></th>
                                        <!-- Increased width for Options column and removed qr_action column -->
                                        <th width="300" class="not-export"><?php echo _l('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($wine_labels)): ?>
                                        <?php foreach($wine_labels as $label): ?>
                                            <tr>
                                                <!-- Added id and label_id data columns -->
                                                <td><span class="label label-default"><?php echo $label->id; ?></span></td>
                                                <td><span class="label label-info"><?php echo isset($label->label_id) ? $label->label_id : '-'; ?></span></td>
                                                <td>
                                                    <?php if(!empty($label->Pic1)): ?>
                                                        <img src="<?php echo QRURL.'store/'.$label->Pic1; ?>" 
                                                             class="img img-responsive staff-profile-image-small" 
                                                             style="width: 35px; height: 35px; object-fit: cover; border-radius: 50%;">
                                                    <?php else: ?>
                                                        <div class="wine-placeholder-small">
                                                            <i class="fa fa-wine-bottle text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo admin_url('qrwine/wine_label/'.$label->id); ?>" class="text-dark">
                                                        <strong><?php echo $label->name; ?></strong>
                                                    </a>
                                                    <?php if(!empty($label->grapev)): ?>
                                                        <br><small class="text-muted"><?php echo $label->grapev; ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo isset($label->producer_name) ? $label->producer_name : '-'; ?></td>
                                                <td><?php echo $label->vintage; ?></td>
                                                <td><?php echo isset($label->bottle_name) ? $label->bottle_name : '-'; ?></td>
                                                <td><span class="label label-info"><?php echo $label->alcohol; ?>%</span></td>
                                                <td><span class="label label-default"><?php echo $label->lot; ?></span></td>
                                                <td>
                                                    <?php if($label->status == 'published'): ?>
                                                        <span class="label label-success"><?php echo _l('published'); ?></span>
                                                    <?php else: ?>
                                                        <span class="label label-warning"><?php echo _l('draft'); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo _d($label->date_created); ?></td>
                                                <td>
                                                    <!-- Fixed onclick handlers to use javascript:void(0) and proper event handling -->
                                                    <div class="action-grid">
                                                        <!-- First row of actions -->
                                                        <div class="action-row">
                                                            <!-- Changed edit button to prevent default behavior -->
                                                            <a href="javascript:void(0);" onclick="openEditModal(<?php echo $label->id; ?>);" 
                                                               class="btn btn-primary btn-action" data-toggle="tooltip" title="<?php echo _l('edit'); ?>">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            
                                                            <a href="<?php echo admin_url('qrwine/delete/'.$label->id); ?>" 
                                                               class="btn btn-primary btn-action _delete" data-toggle="tooltip" title="<?php echo _l('delete'); ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                            
                                                            <!-- Reverting certification modal to simple alert -->
                                                            <!-- Updated certification icon to open hello world modal -->
                                                            <a href="javascript:void(0);" onclick="openHelloWorldModal(<?php echo $label->id; ?>);" 
                                                               class="btn btn-primary btn-sm" 
                                                               data-toggle="tooltip" 
                                                               title="<?php echo _l('qr_certifications'); ?>">
                                                                <i class="fa fa-certificate"></i>
                                                            </a>
                                                            
                                                            <a href="javascript:void(0);" onclick="show_nutrition(<?php echo $label->id; ?>);" 
                                                               class="btn btn-primary btn-action" data-toggle="tooltip" title="<?php echo _l('nutrition_facts'); ?>">
                                                                <i class="fa fa-info"></i>
                                                            </a>
                                                            
                                                            <a href="javascript:void(0);" onclick="openBusinessModal(<?php echo $label->id; ?>);" 
                                                               class="btn btn-primary btn-action" data-toggle="tooltip" title="<?php echo _l('qr_services'); ?>">
                                                                <i class="fa fa-envelope"></i>
                                                            </a>
                                                        </div>
                                                        
                                                        <!-- Second row of actions -->
                                                        <div class="action-row">
                                                            <a href="<?php echo admin_url('qrwine/generate_qr/'.$label->id); ?>" 
                                                               class="btn btn-primary btn-action" data-toggle="tooltip" title="<?php echo _l('generate_qr'); ?>">
                                                                <i class="fa fa-qrcode"></i>
                                                            </a>
                                                            
                                                            <!-- Changed qr_ingredients to Preview -->
                                                            <a href="javascript:void(0);" onclick="openPreviewModal(<?php echo $label->id; ?>);" 
                                                               class="btn btn-primary btn-action" data-toggle="tooltip" title="Preview">
                                                                <i class="fa fa-calendar"></i>
                                                            </a>
                                                            
                                                            <a href="javascript:void(0);" onclick="openRecyclingModal(<?php echo $label->id; ?>);" 
                                                               class="btn btn-primary btn-action" data-toggle="tooltip" title="<?php echo _l('qr_recycling'); ?>">
                                                                <i class="fa fa-th"></i>
                                                            </a>
                                                            
                                                            <a href="<?php echo admin_url('qrwine/duplicate/'.$label->id); ?>" 
                                                               class="btn btn-primary btn-action" data-toggle="tooltip" title="<?php echo _l('duplicate'); ?>">
                                                                <i class="fa fa-trash-o"></i>
                                                            </a>
                                                        </div>
                                                        
                                                        <!-- Publish button -->
                                                        <div class="action-publish">
                                                            <?php if($label->status == 'draft'): ?>
                                                            <a href="<?php echo admin_url('qrwine/publish/'.$label->id); ?>" 
                                                               class="btn btn-info btn-publish">
                                                                <i class="fa fa-arrow-up"></i> <?php echo _l('publish'); ?>
                                                            </a>
                                                            <?php else: ?>
                                                            <a href="<?php echo admin_url('qrwine/unpublish/'.$label->id); ?>" 
                                                               class="btn btn-warning btn-publish">
                                                                <i class="fa fa-arrow-down"></i> <?php echo _l('unpublish'); ?>
                                                            </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <!-- Updated colspan from 10 to 12 since we added 2 more columns -->
                                            <td colspan="12" class="text-center">
                                                <div class="empty-state-container">
                                                    <i class="fa fa-wine-bottle fa-4x text-muted"></i>
                                                    <h4 class="text-muted mtop20"><?php echo _l('no_wine_labels_found'); ?></h4>
                                                    <p class="text-muted"><?php echo _l('create_first_wine_label'); ?></p>
                                                    <a href="<?php echo admin_url('qrwine/wine_label'); ?>" class="btn btn-info mtop15">
                                                        <i class="fa fa-plus"></i> <?php echo _l('add_new_wine_label'); ?>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Perfex CRM style pagination -->
                        <?php if($show_pagination && $total_records > 0): ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted">
                                        <?php echo _l('showing'); ?> <?php echo ($offset + 1); ?> <?php echo _l('to'); ?> 
                                        <?php echo min($offset + $per_page, $total_records); ?> <?php echo _l('of'); ?> 
                                        <?php echo $total_records; ?> <?php echo _l('entries'); ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <div class="pull-right">
                                        <?php if($total_records > $per_page): ?>
                                            <!-- Use CodeIgniter pagination links instead of custom pagination -->
                                            <?php echo $pagination_links; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Removed problematic modal file loading and created inline modals -->
<!-- Removing certification modal include -->
<!-- Include modal files for popup functionality -->
<?php 
// $this->load->view('admin/modals/certification_modal');
?>
<!-- Adding hello world modal include -->
<?php $this->load->view('admin/modals/hello_world_modal'); ?>
<?php $this->load->view('admin/modals/recycling_modal'); ?>
<?php $this->load->view('admin/modals/service_modal'); ?>
<?php $this->load->view('admin/modals/ingredients_modal'); ?>

<!-- Updated nutrition modal to match the compact design from the reference image -->
<!-- Nutrition Modal -->
<div class="modal fade" id="nutritionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nutrition</h4>
            </div>
            <form id="nutritionForm" action="<?php echo admin_url('qrwine/add_nutrition'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="id_label_nutrition" name="id_label_nutrition">
                    
                    <!-- Redesigned nutrition fields with compact inline layout -->
                    <div class="nutrition-field-group">
                        <div class="nutrition-field">
                            <label>Kcal</label>
                            <div class="nutrition-input-wrapper">
                                <input type="number" class="form-control nutrition-input" id="kcal_input" name="kcal_input" step="0.1">
                                <span class="nutrition-unit">Kcal</span>
                            </div>
                        </div>
                        
                        <div class="nutrition-field">
                            <label>Kj</label>
                            <div class="nutrition-input-wrapper">
                                <input type="number" class="form-control nutrition-input" id="kj_input" name="kj_input" step="0.1">
                                <span class="nutrition-unit">Kj</span>
                            </div>
                        </div>
                        
                        <div class="nutrition-field">
                            <label>Fat</label>
                            <div class="nutrition-input-wrapper">
                                <input type="number" class="form-control nutrition-input" id="grassi_input" name="grassi_input" step="0.1">
                                <span class="nutrition-unit">g</span>
                            </div>
                        </div>
                        
                        <div class="nutrition-field">
                            <label>Assidi Saturated Fat</label>
                            <div class="nutrition-input-wrapper">
                                <input type="number" class="form-control nutrition-input" id="saturi_input" name="saturi_input" step="0.1">
                                <span class="nutrition-unit">g</span>
                            </div>
                        </div>
                        
                        <div class="nutrition-field">
                            <label>Carbohydrates</label>
                            <div class="nutrition-input-wrapper">
                                <input type="number" class="form-control nutrition-input" id="carboidrati" name="carboidrati" step="0.1">
                                <span class="nutrition-unit">g</span>
                            </div>
                        </div>
                        
                        <div class="nutrition-field">
                            <label>Sugars</label>
                            <div class="nutrition-input-wrapper">
                                <input type="number" class="form-control nutrition-input" id="zuccheri" name="zuccheri" step="0.1">
                                <span class="nutrition-unit">g</span>
                            </div>
                        </div>
                        
                        <div class="nutrition-field">
                            <label>Protein</label>
                            <div class="nutrition-input-wrapper">
                                <input type="number" class="form-control nutrition-input" id="proteine" name="proteine" step="0.1">
                                <span class="nutrition-unit">g</span>
                            </div>
                        </div>
                        
                        <div class="nutrition-field">
                            <label>Salt</label>
                            <div class="nutrition-input-wrapper">
                                <input type="number" class="form-control nutrition-input" id="sale_input" name="sale_input" step="0.1">
                                <span class="nutrition-unit">g</span>
                            </div>
                        </div>
                        
                        <div class="nutrition-field full-width">
                            <label>Ingredient Normal</label>
                            <input type="text" class="form-control" id="ingredient" name="ingredient">
                        </div>
                        
                        <div class="nutrition-field full-width">
                            <label>Preservatives and Antioxidants</label>
                            <input type="text" class="form-control" id="preservatives" name="preservatives">
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

<!-- Edit Wine Label Modal -->
<div class="modal fade" id="editWineLabelModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php echo _l('edit_wine_label'); ?></h4>
            </div>
            <form id="editWineLabelForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_label_id" name="label_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_wine_name"><?php echo _l('wine_name'); ?> *</label>
                                <input type="text" class="form-control" id="edit_wine_name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_grape_variety"><?php echo _l('grape_variety'); ?></label>
                                <input type="text" class="form-control" id="edit_grape_variety" name="grapev">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_vintage"><?php echo _l('vintage'); ?></label>
                                <input type="number" class="form-control" id="edit_vintage" name="vintage" min="1900" max="2030">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_alcohol"><?php echo _l('alcohol_percentage'); ?></label>
                                <input type="number" class="form-control" id="edit_alcohol" name="alcohol" step="0.1" min="0" max="50">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_lot"><?php echo _l('lot_number'); ?></label>
                                <input type="text" class="form-control" id="edit_lot" name="lot">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_bottle_size"><?php echo _l('bottle_size'); ?></label>
                                <select class="form-control selectpicker" id="edit_bottle_size" name="BottleSize">
                                    <option value=""><?php echo _l('select_bottle_size'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_status"><?php echo _l('status'); ?></label>
                                <select class="form-control selectpicker" id="edit_status" name="status">
                                    <option value="draft"><?php echo _l('draft'); ?></option>
                                    <option value="published"><?php echo _l('published'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_description"><?php echo _l('description'); ?></label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
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

<!-- Added Preview modal with Details UI -->
<div class="modal fade wine-modal" id="PreviewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="width: 80%; max-width: 900px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Wine Label Preview</h4>
            </div>
            <div class="modal-body">
                <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 10px;">
                    <div class="details_label_image" id="image_label_1" style="padding: 5px; flex: 0 0 auto;">
                    </div>
                    <div class="details_label_image" id="image_label_2" style="padding: 5px; flex: 0 0 auto; display: none;">
                    </div>
                    <div class="details_label_image" id="image_label_3" style="padding: 5px; flex: 0 0 auto; display: none;">
                    </div>
                </div>
                
                <div class="wine-header">
                    <h1 id="d_label_name"></h1>
                    <p><?= (isset($info)?$info['name']:'') ?></p>
                </div>
                
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#nutrition_preview" aria-expanded="true"><i class="fa fa-th-large"></i> Primary Info</a></li>
                    <li class=""><a data-toggle="tab" href="#primary_preview" aria-expanded="false"><i class="fa fa-file"></i> Description</a></li>
                </ul>

                <div class="tab-content">
                    <div id="primary_preview" class="tab-pane fade">
                        <div class="row">
                            <div class="col-xs-4 col-md-4 col-sm-4" style="text-align: center;">
                                <div class="wine-section">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 58 58" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-svg"><path d="M46.106,13.556C48.517,10.361,50,6.14,50,1.5h-2c0,8.601-5.547,15.619-12.468,15.967c-0.784-0.461-1.663-0.772-2.602-0.898C32.473,13.149,29.544,10.5,26,10.5c-2.181,0-4.188,1.023-5.496,2.69C19.222,11.556,17.234,10.5,15,10.5c-3.86,0-7,3.14-7,7c0,1.541,0.506,2.999,1.402,4.191C6.311,22.417,4,25.191,4,28.5c0,2.192,1.014,4.15,2.596,5.434C3.919,34.918,2,37.486,2,40.5c0,1.192,0.301,2.334,0.869,3.362C1.133,45.137,0,47.186,0,49.5c0,3.86,3.14,7,7,7c2.505,0,4.7-1.327,5.938-3.31c1.18,0.842,2.602,1.31,4.063,1.31c2.803,0,5.219-1.66,6.336-4.044C24.431,51.133,25.69,51.5,27,51.5c3.113,0,5.756-2.044,6.662-4.86c1.019,0.557,2.161,0.86,3.338,0.86c3.86,0,7-3.14,7-7c0-1.52-0.493-2.925-1.319-4.074C44.703,35.165,46,32.935,46,30.5c0-3.86-3.107-7.023-7-6.992c0-0.003,0-0.005,0-0.008c0-1.611-0.552-3.092-1.47-4.276c2.428-0.498,4.654-1.695,6.537-3.417C44.724,22.364,50.272,27.5,57,27.5h1v-1C58,19.705,52.758,14.12,46.106,13.556z"></path></svg>
                                    <h2>Grape Variety</h2>
                                    <div class="wine-info">
                                        <p id="d_label_grapev"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4 col-md-4 col-sm-4" style="text-align: center;">
                                <div class="wine-section">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon text-svg"><path d="M5.004 10.229l-.003 -.186l.001 -.113l.008 -.071l1 -7a1 1 0 0 1 .877 -.853l.113 -.006h10a1 1 0 0 1 .968 .747l.022 .112l1.006 7.05l.004 .091c0 3.226 -2.56 5.564 -6 5.945v4.055h3a1 1 0 0 1 .117 1.993l-.117 .007h-8a1 1 0 0 1 -.117 -1.993l.117 -.007h3v-4.055c-3.358 -.371 -5.878 -2.609 -5.996 -5.716zm11.129 -6.229h-8.267l-.607 4.258a6.001 6.001 0 0 1 5.125 .787l.216 .155a4 4 0 0 0 4.32 .31l-.787 -5.51z"></path></svg>
                                    <h2 style="font-size: 17px;">Alcohol Content</h2>
                                    <div class="wine-info">
                                        <p id="d_label_alcohol"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4 col-md-4 col-sm-4" style="text-align: center;">
                                <div class="wine-section">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon text-svg"><path d="M13 1a2 2 0 0 1 1.995 1.85l.005 .15v.5c0 1.317 .381 2.604 1.094 3.705l.17 .25l.05 .072a9.093 9.093 0 0 1 1.68 4.92l.006 .354v6.199a3 3 0 0 1 -2.824 2.995l-.176 .005h-6a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-6.2a9.1 9.1 0 0 1 1.486 -4.982l.2 -.292l.05 -.069a6.823 6.823 0 0 0 1.264 -3.957v-.5a2 2 0 0 1 1.85 -1.995l.15 -.005h2zm.362 5h-2.724a8.827 8.827 0 0 1 -1.08 2.334l-.194 .284l-.05 .069a7.091 7.091 0 0 0 -1.307 3.798l-.003 .125a3.33 3.33 0 0 1 1.975 -.61a3.4 3.4 0 0 1 2.833 1.417c.27 .375 .706 .593 1.209 .583a1.4 1.4 0 0 0 1.166 -.583a3.4 3.4 0 0 1 .81 -.8l.003 .183c0 -1.37 -.396 -2.707 -1.137 -3.852l-.228 -.332a8.827 8.827 0 0 1 -1.273 -2.616z"></path></svg>
                                    <h2>Bottle Size</h2>
                                    <div class="wine-info">
                                        <p id="d_label_bottle_size"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4 col-md-4 col-sm-4" style="text-align: center;">
                                <div class="wine-section">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-svg"><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path><path d="M18 14v4h4"></path><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path><path d="M15 3v4"></path><path d="M7 3v4"></path><path d="M3 11h16"></path></svg>
                                    <h2>Vintage</h2>
                                    <div class="wine-info">
                                        <p id="d_label_vintage"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4 col-md-4 col-sm-4" style="text-align: center;">
                                <div class="wine-section">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-svg"><path d="M4 13.5a4 4 0 1 0 4 0v-8.5a2 2 0 1 0 -4 0v8.5"></path><path d="M4 9h4"></path><path d="M13 16a4 4 0 1 0 0 -8a4.07 4.07 0 0 0 -1 .124"></path><path d="M13 3v1"></path><path d="M21 12h1"></path><path d="M13 20v1"></path><path d="M19.4 5.6l-.7 .7"></path><path d="M18.7 17.7l.7 .7"></path></svg>
                                    <h2>Serving Temperature</h2>
                                    <div class="wine-info">
                                        <p id="d_label_serving"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4 col-md-4 col-sm-4" style="text-align: center;">
                                <div class="wine-section">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon text-svg"><path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path><path d="M4 17v1a2 2 0 0 0 2 2h2"></path><path d="M16 4h2a2 2 0 0 1 2 2v1"></path><path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path><path d="M5 11h1v2h-1z"></path><path d="M10 11l0 2"></path><path d="M14 11h1v2h-1z"></path><path d="M19 11l0 2"></path></svg>
                                    <h2>Batch #</h2>
                                    <div class="wine-info">
                                        <p id="d_label_lot"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="divider" style="border-top: 1px solid #000; margin: 15px 0;"></div>

                        <div class="wine-section">
                            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 10px; color: rgb(145 57 84);">Description</h2>
                            <p id="d_label_description"></p>
                        </div>

                        <div class="divider" style="border-top: 1px solid #000; margin: 15px 0;"></div>

                        <div class="wine-section tasting-notes">
                            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 10px; color: rgb(145 57 84);">Tasting Notes</h2>
                            <div class="tasting-note" style="margin-bottom: 10px;">
                                <strong style="font-weight: bold; font-size: 15px;">Color:</strong>
                                <p id="d_label_Tcolor"></p>
                            </div>
                            <div class="tasting-note" style="margin-bottom: 10px;">
                                <strong style="font-weight: bold; font-size: 15px;">Scent:</strong>
                                <p id="d_label_Ttaste"></p>
                            </div>
                            <div class="tasting-note" style="margin-bottom: 10px;">
                                <strong style="font-weight: bold; font-size: 15px;">Pairing:</strong>
                                <p id="d_label_Tpairing"></p>
                            </div>
                        </div>
                    </div>

                    <div id="nutrition_preview" class="tab-pane fade active in">
                        <div class="wine-header">
                            <h1 style="font-weight: bold; margin-bottom: 5px; color: rgb(145 57 84); font-size: 24px;">Nutritional Information</h1>
                        </div>

                        <table class="nutrition-table" style="width: 100%; margin-bottom: 20px; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="background-color: #f5f5f5; color: #000; font-weight: bold; padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Average Values</th>
                                    <th style="background-color: #f5f5f5; color: #000; font-weight: bold; padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Per 100ml</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="background-color: #f9f9f9;">
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;">Energy Value</td>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;"><p id="d_nut_energy">0</p></td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;">Fat</td>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;"><p id="d_nut_fat">0</p></td>
                                </tr>
                                <tr style="background-color: #f9f9f9;">
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;">Saturated Fat</td>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;"><p id="d_nut_sat_fat">0</p></td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;">Carbohydrates</td>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;"><p id="d_nut_carbon">0</p></td>
                                </tr>
                                <tr style="background-color: #f9f9f9;">
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;">Sugars</td>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;"><p id="d_nut_suger">0</p></td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;">Protein</td>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;"><p id="d_nut_protin">0</p></td>
                                </tr>
                                <tr style="background-color: #f9f9f9;">
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;">Salt</td>
                                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; color: #333;"><p id="d_nut_salt">0</p></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="wine-section">
                            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 10px; color: rgb(145 57 84);">Preservatives</h2>
                            <p id="d_nut_conservante"></p>
                        </div>

                        <div class="wine-section">
                            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 10px; color: rgb(145 57 84);">Ingredients</h2>
                            <p id="d_nut_ingredient"></p>
                        </div>

                        <div class="wine-section recycling-info">
                            <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 10px; color: rgb(145 57 84);">Recycling Instructions</h2>
                            <div id="d_recycle_html"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.wine-placeholder-small {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 50%;
    border: 1px solid #dee2e6;
}

.empty-state-container {
    padding: 60px 20px;
}

/* Enhanced row options styling to match reference file */
.row-options {
    display: none;
}

/* Updated CSS to match reference image 2x4 grid layout */
.action-grid {
    display: flex;
    flex-direction: column;
    gap: 5px;
    min-width: 250px;
}

.action-row {
    display: flex;
    gap: 3px;
    justify-content: flex-start;
}

.btn-action {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    border: 1px solid #337ab7;
    background-color: #337ab7;
    color: white;
    font-size: 14px;
}

.btn-action:hover {
    background-color: #286090;
    border-color: #204d74;
    color: white;
}

.action-publish {
    margin-top: 5px;
}

.btn-publish {
    width: 100%;
    padding: 6px 12px;
    font-size: 12px;
    border-radius: 4px;
}

/* Custom stat cards using CSS instead of Tailwind */
.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.stat-card.success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.stat-card.warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-card.info {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.stat-card h3 {
    margin: 0;
    font-size: 2.5rem;
    font-weight: bold;
}

.stat-card p {
    margin: 5px 0 0 0;
    opacity: 0.9;
}

.tw-bg-primary-500 i.fa-3x,
.tw-bg-success-500 i.fa-3x,
.tw-bg-warning-500 i.fa-3x,
.tw-bg-info-500 i.fa-3x {
    font-size: 2.5rem !important;
}

/* Added nutrition modal styling to match the compact design from reference image */
.nutrition-field-group {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.nutrition-field {
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 34px;
}

.nutrition-field.full-width {
    flex-direction: column;
    align-items: flex-start;
    gap: 5px;
}

.nutrition-field label {
    font-weight: 500;
    margin: 0;
    min-width: 180px;
    text-align: left;
    color: #333;
}

.nutrition-field.full-width label {
    min-width: auto;
    margin-bottom: 5px;
}

.nutrition-input-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    max-width: 150px;
}

.nutrition-field.full-width .form-control {
    width: 100%;
    max-width: none;
}

.nutrition-input {
    width: 80px !important;
    text-align: center;
    padding: 6px 8px;
    height: 34px;
}

.nutrition-unit {
    font-weight: 500;
    color: #666;
    min-width: 40px;
    text-align: left;
}

#nutritionModal .modal-dialog {
    max-width: 500px;
}

#nutritionModal .modal-body {
    padding: 20px;
}

#nutritionModal .modal-title {
    font-weight: 600;
    color: #333;
}
</style>

<script>
// Define all functions immediately in global scope without any jQuery dependencies
window.openIngredientModal = function(labelId) {
    console.log("[v0] Opening ingredients modal for label ID:", labelId);
    
    function executeWithJQuery() {
        if (typeof jQuery === 'undefined') {
            console.log("[v0] jQuery not available, retrying...");
            setTimeout(executeWithJQuery, 100);
            return;
        }
        
        try {
            console.log("[v0] jQuery available, opening ingredients modal");
            
            if (jQuery('#IngredientsModal').length === 0) {
                console.error("[v0] Ingredients modal not found in DOM");
                alert('Error: Ingredients modal not found');
                return false;
            }
            
            jQuery('#IngredientsModal').modal('show');
            console.log("[v0] Ingredients modal shown successfully");
            
        } catch (error) {
            console.error("[v0] Error opening ingredients modal:", error);
            alert('Error opening ingredients modal: ' + error.message);
        }
    }
    
    executeWithJQuery();
    return false;
};

window.openBusinessModal = function(labelId) {
    console.log("[v0] Opening service modal for label ID:", labelId);
    
    function executeWithJQuery() {
        if (typeof jQuery === 'undefined') {
            console.log("[v0] jQuery not available, retrying...");
            setTimeout(executeWithJQuery, 100);
            return;
        }
        
        try {
            console.log("[v0] jQuery available, opening service modal");
            
            if (jQuery('#ServiceModal').length === 0) {
                console.error("[v0] Service modal not found in DOM");
                alert('Error: Service modal not found');
                return false;
            }
            
            jQuery('#ServiceModal').modal('show');
            console.log("[v0] Service modal shown successfully");
            
        } catch (error) {
            console.error("[v0] Error opening service modal:", error);
            alert('Error opening service modal: ' + error.message);
        }
    }
    
    executeWithJQuery();
    return false;
};

window.openRecyclingModal = function(labelId) {
    console.log("[v0] Opening recycling modal for label ID:", labelId);
    
    function executeWithJQuery() {
        if (typeof jQuery === 'undefined') {
            console.log("[v0] jQuery not available, retrying...");
            setTimeout(executeWithJQuery, 100);
            return;
        }
        
        try {
            console.log("[v0] jQuery available, opening recycling modal");
            
            if (jQuery('#RecyclingModal').length === 0) {
                console.error("[v0] Recycling modal not found in DOM");
                alert('Error: Recycling modal not found');
                return false;
            }
            
            jQuery('#RecyclingModal').modal('show');
            console.log("[v0] Recycling modal shown successfully");
            
        } catch (error) {
            console.error("[v0] Error opening recycling modal:", error);
            alert('Error opening recycling modal: ' + error.message);
        }
    }
    
    executeWithJQuery();
    return false;
};

window.openHelloWorldModal = function(labelId) {
    console.log("[v0] Opening hello world modal for label ID:", labelId);
    
    function executeWithJQuery() {
        if (typeof jQuery === 'undefined') {
            console.log("[v0] jQuery not available, retrying...");
            setTimeout(executeWithJQuery, 100);
            return;
        }
        
        try {
            console.log("[v0] jQuery available, opening hello world modal");
            
            if (jQuery('#HelloWorldModal').length === 0) {
                console.error("[v0] Hello World modal not found in DOM");
                alert('Error: Hello World modal not found');
                return false;
            }
            
            jQuery('#HelloWorldModal').modal('show');
            console.log("[v0] Hello World modal shown successfully");
            
        } catch (e) {
            console.error("[v0] Exception in openHelloWorldModal:", e);
            alert('Error opening hello world modal: ' + e.message);
        }
    }
    
    executeWithJQuery();
    return false;
};

window.show_nutrition = function(id) {
    console.log("[v0] Opening nutrition modal for label ID:", id);
    
    if (!id || id === 'undefined' || id === 'null') {
        console.error("[v0] Invalid label ID provided:", id);
        alert('Error: Invalid label ID');
        return false;
    }
    
    function executeWithJQuery() {
        if (typeof jQuery === 'undefined') {
            console.log("[v0] jQuery not available, retrying...");
            setTimeout(executeWithJQuery, 100);
            return;
        }
        
        try {
            console.log("[v0] jQuery available, loading nutrition data");
            
            if (jQuery('#nutritionForm').length > 0) {
                jQuery('#nutritionForm')[0].reset();
            }
            jQuery('#id_label_nutrition').val(id);
            
            jQuery.ajax({
                type: 'GET',
                url: '<?php echo admin_url("qrwine/detail_nutrition/"); ?>' + id,
                dataType: 'json',
                success: function(response) {
                    console.log("[v0] Nutrition data loaded:", response);
                    console.log("[v0] Response data structure:", JSON.stringify(response, null, 2));
                    
                    if (response.success && response.data) {
                        var data = response.data;
                        console.log("[v0] Populating fields with data:", data);
                        
                        if (data.kcal !== undefined) {
                            jQuery('#kcal_input').val(data.kcal);
                            console.log("[v0] Set kcal:", data.kcal);
                        }
                        if (data.kj !== undefined) {
                            jQuery('#kj_input').val(data.kj);
                            console.log("[v0] Set kj:", data.kj);
                        }
                        if (data.grassi !== undefined) {
                            jQuery('#grassi_input').val(data.grassi);
                            console.log("[v0] Set grassi:", data.grassi);
                        }
                        if (data.grassi_saturi !== undefined) {
                            jQuery('#saturi_input').val(data.grassi_saturi);
                            console.log("[v0] Set grassi_saturi:", data.grassi_saturi);
                        }
                        if (data.carboidrati !== undefined) {
                            jQuery('#carboidrati').val(data.carboidrati);
                            console.log("[v0] Set carboidrati:", data.carboidrati);
                        }
                        if (data.zuccheri !== undefined) {
                            jQuery('#zuccheri').val(data.zuccheri);
                            console.log("[v0] Set zuccheri:", data.zuccheri);
                        }
                        if (data.proteine !== undefined) {
                            jQuery('#proteine').val(data.proteine);
                            console.log("[v0] Set proteine:", data.proteine);
                        }
                        if (data.sale !== undefined) {
                            jQuery('#sale_input').val(data.sale);
                            console.log("[v0] Set sale:", data.sale);
                        }
                        if (data.Ingredient !== undefined) {
                            jQuery('#ingredient').val(data.Ingredient);
                            console.log("[v0] Set Ingredient:", data.Ingredient);
                        }
                        if (data.preservatives !== undefined) {
                            jQuery('#preservatives').val(data.preservatives);
                            console.log("[v0] Set preservatives:", data.preservatives);
                        }
                        
                        setTimeout(function() {
                            console.log("[v0] Verifying field values after population:");
                            console.log("kcal_input:", jQuery('#kcal_input').val());
                            console.log("kj_input:", jQuery('#kj_input').val());
                            console.log("grassi_input:", jQuery('#grassi_input').val());
                            console.log("saturi_input:", jQuery('#saturi_input').val());
                            console.log("carboidrati:", jQuery('#carboidrati').val());
                            console.log("zuccheri:", jQuery('#zuccheri').val());
                            console.log("proteine:", jQuery('#proteine').val());
                            console.log("sale_input:", jQuery('#sale_input').val());
                            console.log("ingredient:", jQuery('#ingredient').val());
                            console.log("preservatives:", jQuery('#preservatives').val());
                        }, 100);
                        
                        console.log("[v0] Form populated with nutrition data");
                    } else {
                        console.log("[v0] No existing nutrition data found, showing empty form");
                        console.log("[v0] Response:", response);
                    }
                    
                    // Show modal after data is loaded
                    jQuery('#nutritionModal').modal('show');
                    console.log("[v0] Nutrition modal shown successfully");
                },
                error: function(xhr, status, error) {
                    console.error("[v0] Error loading nutrition data:", status, error);
                    console.error("[v0] XHR response:", xhr.responseText);
                    // Show modal even if data loading fails
                    jQuery('#nutritionModal').modal('show');
                    console.log("[v0] Nutrition modal shown with empty form due to error");
                }
            });
            
        } catch (e) {
            console.error("[v0] Exception in show_nutrition:", e);
            alert('Error opening nutrition modal: ' + e.message);
        }
    }
    
    executeWithJQuery();
    return false;
};

window.openEditModal = function(labelId) {
    console.log("[v0] Opening edit modal for label ID:", labelId);
    
    if (!labelId || labelId === 'undefined' || labelId === 'null') {
        console.error("[v0] Invalid label ID provided:", labelId);
        alert('Error: Invalid label ID');
        return false;
    }
    
    function executeWithJQuery() {
        if (typeof jQuery === 'undefined') {
            console.log("[v0] jQuery not available, retrying...");
            setTimeout(executeWithJQuery, 100);
            return;
        }
        
        try {
            console.log("[v0] jQuery available, opening edit modal");
            
            if (jQuery('#editWineLabelModal').length === 0) {
                console.error("[v0] Edit modal not found in DOM");
                alert('Error: Edit modal not found');
                return false;
            }
            
            jQuery('#edit_label_id').val(labelId);
            jQuery('#editWineLabelModal').modal('show');
            console.log("[v0] Edit modal shown successfully");
            
        } catch (e) {
            console.error("[v0] Exception in openEditModal:", e);
            alert('Error opening edit modal: ' + e.message);
        }
    }
    
    executeWithJQuery();
    return false;
};

window.populatePreviewModal = function(data) {
    if (typeof jQuery === 'undefined') return;
    
    // Populate wine header
    jQuery('#d_label_name').text(data.wine_name || '');
    jQuery('#d_label_grapev').text(data.grape_variety || '');
    jQuery('#d_label_alcohol').text((data.alcohol || '') + '%');
    jQuery('#d_label_vintage').text(data.vintage || '');
    jQuery('#d_label_serving').text(data.serve_to || '');
    jQuery('#d_label_lot').text(data.lot || '');
    jQuery('#d_label_description').text(data.description || '');
    jQuery('#d_label_characteristics').text(data.characteristics || '');
    jQuery('#d_label_Tcolor').text(data.color || '');
    jQuery('#d_label_Ttaste').text(data.scent_taste || '');
    jQuery('#d_label_Tpairing').text(data.pairing || '');
    
    // Populate bottle size
    jQuery('#d_label_bottle_size').text(data.bottle_name || '750ml');
    
    // Populate nutrition information
    jQuery('#d_nut_energy').text(data.nut_energy + ' Kcal');
    jQuery('#d_nut_fat').text(data.nut_fat + ' g');
    jQuery('#d_nut_sat_fat').text(data.nut_sat_fat + ' g');
    jQuery('#d_nut_carbon').text(data.nut_carbon + ' g');
    jQuery('#d_nut_suger').text(data.nut_suger + ' g');
    jQuery('#d_nut_protin').text(data.nut_protin + ' g');
    jQuery('#d_nut_salt').text(data.nut_salt + ' g');
    jQuery('#d_nut_conservante').text(data.nut_conservante || '');
    jQuery('#d_nut_ingredient').text(data.nut_ingredient || '');
    
    // Populate recycling information
    jQuery('#d_recycle_html').html(data.recycle_html || '');
};

window.openPreviewModal = function(labelId) {
    console.log('[v0] Opening preview modal for label ID:', labelId);
    
    if (typeof jQuery === 'undefined') {
        console.error('[v0] jQuery not available for preview modal');
        alert('Preview functionality requires jQuery to be loaded');
        return;
    }
    
    try {
        // Load preview data via AJAX
        jQuery.ajax({
            url: admin_url + 'qrwine/detail_preview/' + labelId,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                console.log('[v0] Preview data loaded:', response);
                
                if (response.success && response.data) {
                    // Populate modal with data
                    window.populatePreviewModal(response.data);
                    console.log('[v0] Preview modal populated with data');
                } else {
                    console.warn('[v0] No preview data available:', response.message);
                    // Show modal with empty data
                }
                
                // Show the modal
                jQuery('#PreviewModal').modal('show');
                console.log('[v0] Preview modal shown');
            },
            error: function(xhr, status, error) {
                console.error('[v0] Error loading preview data:', error);
                alert('Error loading preview data: ' + error);
                
                // Show modal anyway with empty data
                jQuery('#PreviewModal').modal('show');
            }
        });
        
    } catch (error) {
        console.error('[v0] Preview modal error:', error);
        alert('Error opening preview modal: ' + error.message);
    }
};

(function() {
    'use strict';
    
    console.log("[v0] Dashboard script loaded");
    
    function initializeDashboard() {
        if (typeof jQuery === 'undefined') {
            console.log("[v0] Waiting for jQuery...");
            setTimeout(initializeDashboard, 100);
            return;
        }
        
        jQuery(document).ready(function($) {
            console.log("[v0] Dashboard JavaScript initialized successfully");
            
            // Initialize selectpicker if available
            try {
                if ($.fn.selectpicker) {
                    $('.selectpicker').selectpicker();
                    console.log("[v0] Selectpicker initialized");
                }
            } catch (e) {
                console.log("[v0] Selectpicker not available:", e.message);
            }
            
            // Initialize tooltips if available
            try {
                if ($.fn.tooltip) {
                    $('[data-toggle="tooltip"]').tooltip();
                    console.log("[v0] Tooltips initialized");
                }
            } catch (e) {
                console.log("[v0] Tooltips not available:", e.message);
            }
            
            // Search and filter functionality
            $('#btn_search, #filter_status, #filter_producer').on('click change', function() {
                try {
                    var search = $('#search_labels').val();
                    var status = $('#filter_status').val();
                    var producer = $('#filter_producer').val();
                    
                    var url = '<?php echo admin_url("qrwine"); ?>?';
                    var params = [];
                    
                    if(search) params.push('search=' + encodeURIComponent(search));
                    if(status) params.push('status=' + status);
                    if(producer) params.push('producer=' + producer);
                    
                    if(params.length > 0) {
                        url += params.join('&');
                    }
                    
                    console.log("[v0] Navigating to:", url);
                    window.location.href = url;
                } catch (e) {
                    console.error("[v0] Error in search/filter:", e);
                }
            });
            
            // Enter key search
            $('#search_labels').on('keypress', function(e) {
                if(e.which == 13) {
                    $('#btn_search').click();
                }
            });
            
            // Handle nutrition form submission
            $('#nutritionForm').on('submit', function(e) {
                e.preventDefault();
                
                try {
                    var formData = $(this).serialize();
                    console.log("[v0] Submitting nutrition form:", formData);
                    
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            console.log("[v0] Nutrition form response:", response);
                            if (response.alert === 'success') {
                                alert('Nutrition data saved successfully!');
                                $('#nutritionModal').modal('hide');
                                location.reload();
                            } else {
                                alert('Error saving nutrition data');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("[v0] Nutrition form error:", status, error);
                            alert('Error submitting form: ' + error);
                        }
                    });
                } catch (e) {
                    console.error("[v0] Exception in form submission:", e);
                    alert('Error: ' + e.message);
                }
            });
            
            console.log("[v0] Dashboard initialization complete");
        });
    }
    
    initializeDashboard();
})();
</script>

<?php init_tail(); ?>
</div>
</body>
</html>
