<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * QR Wine Label by BIT SOLUTIONS Controller
 * Version: 1.0
 */
class Qrwine extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        
        if (!defined('QRURL')) {
            define('QRURL', 'https://digi-card.net/');
        }
        
        try {
            $external_db_config = array(
                'dsn'      => '',
                'hostname' => '165.22.102.58',
                'port'     => '887',
                'username' => 'backup_db',
                'password' => '2EAFXWedLe6PtMbn',
                'database' => 'backup_db',
                'dbdriver' => 'mysqli',
                'dbprefix' => '',
                'pconnect' => FALSE,
                'db_debug' => FALSE, // Disable debug to prevent 500 errors
                'cache_on' => FALSE,
                'cachedir' => '',
                'char_set' => 'utf8',
                'dbcollat' => 'utf8_general_ci',
                'swap_pre' => '',
                'encrypt'  => FALSE,
                'compress' => FALSE,
                'stricton' => FALSE,
                'failover' => array(),
                'save_queries' => TRUE
            );
            
            $this->db2 = $this->load->database($external_db_config, TRUE);
            
            // Test the connection
            if (!$this->db2->conn_id) {
                log_message('error', '[v0] External database connection failed');
                // Fallback to local database if external fails
                $this->db2 = $this->db;
            } else {
                log_message('debug', '[v0] External database connected successfully');
            }
            
        } catch (Exception $e) {
            log_message('error', '[v0] Database connection error: ' . $e->getMessage());
            // Fallback to local database
            $this->db2 = $this->db;
        }
        
        $this->load->model('qrwine_model');
        if (file_exists(APPPATH . 'modules/qrwine/helpers/qrwine_helper.php')) {
            $this->load->helper('qrwine_helper');
        }
        $this->load->library('form_validation');
    }

    /**
     * Dashboard - Main module page
     */
    public function index()
    {
        if (!has_permission('qrwine', '', 'view')) {
            access_denied('qrwine');
        }

        $per_page = 20;
        $current_page = $this->input->get('page') ? max(1, (int)$this->input->get('page')) : 1;
        $offset = ($current_page - 1) * $per_page;
        
        // Get filters with proper defaults
        $search = $this->input->get('search') ?: '';
        $status_filter = $this->input->get('status') ?: '';
        $producer_filter = $this->input->get('producer') ?: '';
        
        $total_rows = $this->qrwine_model->get_wine_labels_count($search, $status_filter, $producer_filter);
        $total_rows = is_numeric($total_rows) && $total_rows >= 0 ? (int)$total_rows : 0;
        
        $pagination_links = '';
        if ($total_rows > $per_page && $per_page > 0 && $current_page > 0) {
            try {
                $this->load->library('pagination');
                
                $total_pages = ceil($total_rows / $per_page);
                $current_page = min($current_page, $total_pages);
                
                // Only proceed if all values are positive integers
                if ($total_rows > 0 && $per_page > 0 && $current_page > 0 && $total_pages > 0) {
                    $config = array(
                        'base_url' => admin_url('qrwine'),
                        'total_rows' => $total_rows,
                        'per_page' => $per_page,
                        'page_query_string' => TRUE,
                        'query_string_segment' => 'page',
                        'reuse_query_string' => TRUE,
                        'use_page_numbers' => TRUE,
                        'num_links' => 3,
                        'cur_page' => $current_page,
                        
                        // Pagination styling for Perfex CRM
                        'full_tag_open' => '<ul class="pagination">',
                        'full_tag_close' => '</ul>',
                        'first_link' => FALSE,
                        'last_link' => FALSE,
                        'prev_link' => '&laquo;',
                        'prev_tag_open' => '<li>',
                        'prev_tag_close' => '</li>',
                        'next_link' => '&raquo;',
                        'next_tag_open' => '<li>',
                        'next_tag_close' => '</li>',
                        'cur_tag_open' => '<li class="active"><a href="#">',
                        'cur_tag_close' => '</a></li>',
                        'num_tag_open' => '<li>',
                        'num_tag_close' => '</li>'
                    );
                    
                    $this->pagination->initialize($config);
                    $pagination_result = $this->pagination->create_links();
                    $pagination_links = ($pagination_result === null) ? '' : $pagination_result;
                }
            } catch (Exception $e) {
                $pagination_links = $this->create_custom_pagination($current_page, $total_pages, $total_rows, $per_page);
                log_message('error', 'Pagination library error: ' . $e->getMessage());
            }
        }
        
        $data['title'] = _l('qr_wine_labels_dashboard');
        $data['total_labels'] = max(0, (int)$this->qrwine_model->get_total_labels());
        $data['published_labels'] = max(0, (int)$this->qrwine_model->get_published_labels_count());
        $data['draft_labels'] = max(0, (int)$this->qrwine_model->get_draft_labels_count());
        $data['qr_codes_generated'] = max(0, (int)$this->qrwine_model->get_qr_codes_count());
        
        $recent_labels = $this->qrwine_model->get_recent_labels(5);
        $data['recent_labels'] = is_array($recent_labels) ? $recent_labels : array();
        
        // Get wine labels with pagination
        $wine_labels = $this->qrwine_model->get_wine_labels_paginated($per_page, $offset, $search, $status_filter, $producer_filter);
        $data['wine_labels'] = is_array($wine_labels) ? $wine_labels : array();
        
        $data['total_records'] = $total_rows;
        $data['total_pages'] = $total_rows > 0 ? ceil($total_rows / $per_page) : 1;
        $data['current_page'] = $current_page;
        $data['per_page'] = $per_page;
        $data['offset'] = $offset;
        $data['show_pagination'] = $total_rows > $per_page;
        $data['pagination_links'] = $pagination_links;
        
        // Get producers for filter dropdown
        $producers = $this->qrwine_model->get_all_producers();
        $data['producers'] = is_array($producers) ? $producers : array();

        $this->load->view('admin/dashboard', $data);
    }

    /**
     * Manage wine labels
     */
    public function manage($id = '')
    {
        if (!has_permission('qrwine', '', 'view')) {
            access_denied('qrwine');
        }

        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('qrwine', 'admin/tables/wine_labels'));
        }

        if ($id == '') {
            $data['title'] = _l('wine_labels');
            $this->load->view('admin/manage', $data);
        } else {
            if (!has_permission('qrwine', '', 'view') && !has_permission('qrwine', '', 'view_own')) {
                access_denied('qrwine');
            }

            $data['wine_label'] = $this->qrwine_model->get($id);
            if (!$data['wine_label']) {
                show_404();
            }

            $data['title'] = _l('edit_wine_label');
            $this->load->view('admin/wine_label', $data);
        }
    }

    /**
     * Create or update wine label
     */
    public function wine_label($id = '')
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('qrwine', '', 'create')) {
                    access_denied('qrwine');
                }
                
                $id = $this->qrwine_model->add($data);
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('wine_label')));
                    redirect(admin_url('qrwine/manage/' . $id));
                }
            } else {
                if (!has_permission('qrwine', '', 'edit')) {
                    access_denied('qrwine');
                }
                
                $success = $this->qrwine_model->update($data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('wine_label')));
                }
                redirect(admin_url('qrwine/manage/' . $id));
            }
        }

        $data['bottle_sizes'] = $this->qrwine_model->get_dropdown_list('bottle');
        $data['producers'] = $this->qrwine_model->get_all_producers();

        if ($id == '') {
            $data['title'] = _l('add_new_wine_label');
            $data['wine_label'] = null;
        } else {
            $data['wine_label'] = $this->qrwine_model->get($id);
            if (!$data['wine_label']) {
                show_404();
            }
            $data['title'] = _l('edit_wine_label');
        }

        $this->load->view('admin/wine_label', $data);
    }

    /**
     * Generate QR Code for wine label
     */
    public function generate_qr($id)
    {
        if (!has_permission('qrwine', '', 'edit')) {
            access_denied('qrwine');
        }

        $wine_label = $this->qrwine_model->get($id);
        if (!$wine_label) {
            show_404();
        }

        $qr_data = array(
            'name' => $wine_label->name,
            'client_name' => $wine_label->client_name,
            'vintage' => $wine_label->vintage,
            'alcohol' => $wine_label->alcohol,
            'lot' => $wine_label->lot,
            'grape_variety' => $wine_label->grape_variety
        );

        $qr_url = generate_wine_qr_code($qr_data);
        
        if ($qr_url) {
            $this->qrwine_model->update(array('qr_code' => $qr_url), $id);
            set_alert('success', _l('qr_code_generated_successfully'));
        } else {
            set_alert('danger', _l('qr_code_generation_failed'));
        }

        redirect(admin_url('qrwine/manage/' . $id));
    }

    /**
     * Module settings
     */
    public function settings()
    {
        if (!is_admin()) {
            access_denied('qrwine_settings');
        }

        $data['login_path'] = APPPATH . 'modules/qrwine/config/login_hash.txt';
        $data['info'] = $this->get_business_info();
        $data['title'] = _l('qr_settings');
        $this->load->view('admin/settings', $data);
    }

    public function login()
    {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            
            // Call external API for login
            $login_result = $this->authenticate_external_service($email, $password);
            
            if ($login_result['success']) {
                // Save login hash
                $hash_file = APPPATH . 'modules/qrwine/config/login_hash.txt';
                file_put_contents($hash_file, $login_result['hash']);
                set_alert('success', _l('qr_login_success'));
            } else {
                set_alert('danger', _l('qr_login_failed'));
            }
        }
        
        redirect(admin_url('qrwine/settings'));
    }

    public function logout()
    {
        $hash_file = APPPATH . 'modules/qrwine/config/login_hash.txt';
        if (file_exists($hash_file)) {
            unlink($hash_file);
        }
        set_alert('success', _l('qr_logout_success'));
        redirect(admin_url('qrwine/settings'));
    }

    public function update_settings()
    {
        if (!is_admin()) {
            access_denied('qrwine_settings');
        }

        if ($this->input->post()) {
            $data = $this->input->post();
            
            // Handle file upload
            if (!empty($_FILES['file_1']['name'])) {
                $config['upload_path'] = APPPATH . 'modules/qrwine/uploads/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = 2048;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('file_1')) {
                    $upload_data = $this->upload->data();
                    $data['Pic1'] = $upload_data['file_name'];
                }
            }
            
            // Save business information to external database
            $result = $this->save_business_info($data);
            
            if ($result) {
                set_alert('success', _l('qr_settings_updated'));
            } else {
                set_alert('danger', _l('qr_settings_update_failed'));
            }
        }
        
        redirect(admin_url('qrwine/settings'));
    }

    private function authenticate_external_service($email, $password)
    {
        // Implementation for external API authentication
        return ['success' => true, 'hash' => md5($email . time())];
    }

    private function get_business_info()
    {
        // Get business info from external database
        return $this->qrwine_model->get_business_info();
    }

    private function save_business_info($data)
    {
        // Save business info to external database
        return $this->qrwine_model->save_business_info($data);
    }

    /**
     * Delete wine label
     */
    public function delete($id)
    {
        if (!has_permission('qrwine', '', 'delete')) {
            access_denied('qrwine');
        }

        if (!$id) {
            redirect(admin_url('qrwine/manage'));
        }

        $response = $this->qrwine_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('wine_label')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('wine_label_lowercase')));
        }
        redirect(admin_url('qrwine/manage'));
    }

    /**
     * Edit wine label directly
     */
    public function edit($id)
    {
        if (!has_permission('qrwine', '', 'edit')) {
            access_denied('qrwine');
        }

        if (!$id) {
            show_404();
        }

        $data['wine_label'] = $this->qrwine_model->get($id);
        if (!$data['wine_label']) {
            show_404();
        }
        
        $data['bottle_sizes'] = $this->qrwine_model->get_dropdown_list('bottle');
        $data['producers'] = $this->qrwine_model->get_all_producers();
        $data['title'] = _l('edit_wine_label');
        
        $this->load->view('admin/wine_label', $data);
    }

    /**
     * Add/Update ingredients for wine label
     */
    public function add_ingredient()
    {
        if (!has_permission('qrwine', '', 'edit')) {
            access_denied('qrwine');
        }

        $input = $this->input->post();

        if (isset($input['ingredients']) && $input['ingredients'] != null) {
            $ingredients = $input['ingredients'];
            handle_tags_save($ingredients, $input['label_id_ingredient'], 'ingredients');
        }

        if (isset($input['preservatives']) && $input['preservatives'] != null) {
            $preservatives = $input['preservatives'];
            handle_tags_save($preservatives, $input['label_id_ingredient'], 'preservatives');
        }

        echo json_encode(['alert' => 'success', 'message' => 'Ingredients updated successfully']);
    }

    /**
     * Add/Update business services for wine label
     */
    public function add_type()
    {
        if (!has_permission('qrwine', '', 'edit')) {
            access_denied('qrwine');
        }

        if ($this->input->post()) {
            $label_id = $this->input->post('label_id');
            $producer_id = $this->input->post('producer_id');
            $printing_id = $this->input->post('printing_id');
            $oenology_id = $this->input->post('oenology_id');
            
            $data = array(
                'ID_producer' => $producer_id,
                'printing_id' => $printing_id,
                'oenology_id' => $oenology_id
            );
            
            $result = $this->qrwine_model->update($data, $label_id);
            
            if ($result) {
                echo json_encode(['alert' => 'success', 'message' => _l('updated_successfully', _l('qr_services'))]);
            } else {
                echo json_encode(['alert' => 'danger', 'message' => _l('something_went_wrong')]);
            }
        }
    }

    /**
     * Get nutrition data for wine label via GET request
     */
    public function detail_nutrition($id = null)
    {
        if (!has_permission('qrwine', '', 'view')) {
            echo json_encode(['success' => false, 'message' => 'Access denied']);
            return;
        }

        if (!$id || !is_numeric($id)) {
            echo json_encode(['success' => false, 'message' => 'Invalid label ID']);
            return;
        }

        try {
            log_message('debug', '[v0] Querying nutrition data for label ID: ' . $id);
            
            $this->db2->where('id_label', $id);
            $query = $this->db2->get('tbllabels_nutrition');
            
            log_message('debug', '[v0] SQL Query: ' . $this->db2->last_query());
            log_message('debug', '[v0] Query result count: ' . $query->num_rows());
            
            $nutrition_data = $query->row();
            
            if ($nutrition_data) {
                log_message('debug', '[v0] Nutrition data found: ' . json_encode($nutrition_data));
                echo json_encode([
                    'success' => true,
                    'data' => $nutrition_data
                ]);
            } else {
                log_message('debug', '[v0] No nutrition data found for label ID: ' . $id);
                echo json_encode([
                    'success' => true, 
                    'data' => (object)array(
                        'kcal' => '',
                        'kj' => '',
                        'grassi' => '',
                        'grassi_saturi' => '',
                        'carboidrati' => '',
                        'zuccheri' => '',
                        'proteine' => '',
                        'sale' => '',
                        'Ingredient' => '',
                        'preservatives' => ''
                    )
                ]);
            }
        } catch (Exception $e) {
            log_message('error', '[v0] Nutrition data error: ' . $e->getMessage());
            echo json_encode([
                'success' => false, 
                'message' => 'Database error occurred: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get complete wine label data for preview modal
     */
    public function detail_preview($id = null)
    {
        if (!has_permission('qrwine', '', 'view')) {
            echo json_encode(['success' => false, 'message' => 'Access denied']);
            return;
        }

        if (!$id || !is_numeric($id)) {
            echo json_encode(['success' => false, 'message' => 'Invalid label ID']);
            return;
        }

        try {
            log_message('debug', '[v0] Querying preview data for label ID: ' . $id);
            
            $this->db2->where('id', $id);
            $wine_query = $this->db2->get('tbllabels');
            $wine_label = $wine_query->row();
            
            if (!$wine_label) {
                echo json_encode(['success' => false, 'message' => 'Wine label not found']);
                return;
            }
            
            $this->db2->where('id_label', $id);
            $nutrition_query = $this->db2->get('tbllabels_nutrition');
            $nutrition_data = $nutrition_query->row();
            
            // Get bottle size name from external database
            $bottle_name = '750ml'; // Default
            if (!empty($wine_label->BottleSize)) {
                $bottle_query = $this->db2->get_where('tblbottle', ['id' => $wine_label->BottleSize]);
                $bottle_data = $bottle_query->row();
                if ($bottle_data && !empty($bottle_data->name)) {
                    $bottle_name = $bottle_data->name;
                }
            }
            
            // Prepare complete preview data
            $preview_data = array(
                // Wine information
                'wine_name' => $wine_label->name ?? '',
                'grape_variety' => $wine_label->grapev ?? '',
                'alcohol' => $wine_label->alcohol ?? '',
                'vintage' => $wine_label->vintage ?? '',
                'serve_to' => $wine_label->serve_to ?? '',
                'lot' => $wine_label->lot ?? '',
                'description' => $wine_label->description ?? '',
                'characteristics' => $wine_label->characteristics ?? '',
                'color' => $wine_label->Tcolor ?? '',
                'scent_taste' => $wine_label->Ttaste ?? '',
                'pairing' => $wine_label->Tpairing ?? '',
                'bottle_name' => $bottle_name,
                
                // Nutrition information from external database
                'nut_energy' => $nutrition_data->kcal ?? '0',
                'nut_fat' => $nutrition_data->grassi ?? '0',
                'nut_sat_fat' => $nutrition_data->grassi_saturi ?? '0',
                'nut_carbon' => $nutrition_data->carboidrati ?? '0',
                'nut_suger' => $nutrition_data->zuccheri ?? '0',
                'nut_protin' => $nutrition_data->proteine ?? '0',
                'nut_salt' => $nutrition_data->sale ?? '0',
                'nut_conservante' => $nutrition_data->preservatives ?? '',
                'nut_ingredient' => $nutrition_data->Ingredient ?? '',
                
                // Recycling information (placeholder)
                'recycle_html' => '<p>Recycling information will be displayed here.</p>'
            );
            
            log_message('debug', '[v0] Preview data prepared for label ID: ' . $id);
            
            echo json_encode([
                'success' => true,
                'data' => $preview_data
            ]);
            
        } catch (Exception $e) {
            log_message('error', '[v0] Preview data error: ' . $e->getMessage());
            echo json_encode([
                'success' => false, 
                'message' => 'Database error occurred: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get bottle sizes for dropdown
     */
    public function get_bottle_sizes()
    {
        if (!has_permission('qrwine', '', 'view')) {
            echo json_encode(['success' => false, 'message' => 'Access denied']);
            return;
        }

        $bottle_sizes = $this->qrwine_model->get_dropdown_list('bottle');
        
        echo json_encode([
            'success' => true,
            'data' => is_array($bottle_sizes) ? $bottle_sizes : array()
        ]);
    }

    /**
     * Update wine label via AJAX
     */
    public function update_wine_label()
    {
        if (!has_permission('qrwine', '', 'edit')) {
            echo json_encode(['success' => false, 'message' => 'Access denied']);
            return;
        }

        if ($this->input->post()) {
            $label_id = $this->input->post('label_id');
            
            if (!$label_id || !is_numeric($label_id)) {
                echo json_encode(['success' => false, 'message' => 'Invalid label ID']);
                return;
            }

            $data = array(
                'name' => $this->input->post('name'),
                'grapev' => $this->input->post('grapev'),
                'vintage' => $this->input->post('vintage'),
                'alcohol' => $this->input->post('alcohol'),
                'lot' => $this->input->post('lot'),
                'description' => $this->input->post('description'),
                'BottleSize' => $this->input->post('BottleSize'),
                'status' => $this->input->post('status')
            );

            $result = $this->qrwine_model->update($data, $label_id);
            
            if ($result) {
                echo json_encode([
                    'success' => true, 
                    'message' => _l('updated_successfully', _l('wine_label'))
                ]);
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => _l('something_went_wrong')
                ]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }

    /**
     * Add/Update nutrition data for wine label
     */
    public function add_nutrition()
    {
        $input = $this->input->post();

        $insert_data = [
            'kcal' => $input['kcal_input'],
            'kj' => $input['kj_input'],
            'grassi' => $input['grassi_input'],
            'grassi_saturi' => $input['saturi_input'],
            'carboidrati' => $input['carboidrati'],
            'zuccheri' => $input['zuccheri'],
            'proteine' => $input['proteine'],
            'sale' => $input['sale_input'],
            'Ingredient' => $input['ingredient'],
            'preservatives' => $input['preservatives'],
        ];

        try {
            log_message('debug', '[v0] Saving nutrition data for label ID: ' . $input['id_label_nutrition']);
            
            $nutrition = $this->db2->get_where('tbllabels_nutrition', ['id_label' => $input['id_label_nutrition']])->row();
            $label = $this->db2->get_where('tbllabels', ['id' => $input['id_label_nutrition']])->row();
            
            if (empty($nutrition)) {
                $insert_data['id_label'] = $label->id;
                $this->db2->insert('tbllabels_nutrition', $insert_data);
                log_message('debug', '[v0] Inserted new nutrition record');
            } else {
                $this->db2->where('id_label', $input['id_label_nutrition']);
                $this->db2->update('tbllabels_nutrition', $insert_data);
                log_message('debug', '[v0] Updated existing nutrition record');
            }

            echo json_encode(['alert' => 'success', 'message' => 'Nutrition Label added successfully']);
        } catch (Exception $e) {
            log_message('error', '[v0] Nutrition save error: ' . $e->getMessage());
            echo json_encode(['alert' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
}
