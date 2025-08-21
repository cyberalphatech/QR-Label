<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Qr_labels extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->db2 = $this->load->database('db2', TRUE);
        $this->login_path = 'modules/qr_labels/login_'.get_staff_user_id().'.txt';
    }

    public function dashboard()
    {
        $data['title'] = _l('dashboard_string');
        $data['total_labels'] = $this->db2->get_where(db_prefix() . 'labels', ['module_id' => module_id()])->num_rows();
        $data['published_labels'] = $this->db2->get_where(db_prefix() . 'labels', ['module_id' => module_id(), 'status' => 1])->num_rows();
        $data['draft_labels'] = $this->db2->get_where(db_prefix() . 'labels', ['module_id' => module_id(), 'status' => 0])->num_rows();
        
        $this->load->view('dashboard', $data);
    }

    public function label_list()
    {
        $type = get_type();
        if($type == false || $type == 0){
            set_alert('danger', _l('qr_type_message'));
            redirect(admin_url('qr_labels/settings'));
        }
        
        $data['title'] = _l('qr_label_list');
        $data['info'] = $this->db2->get_where('tbllabels_client', ['module_id' => module_id()])->row_array();
        $data['bottle'] = $this->db2->get_where('tbldropdown_list', ['type' => 'bottle'])->result_array();
        $data['labels'] = $this->db2->get_where(db_prefix() . 'labels', ['module_id' => module_id(), 'is_delete' => 0])->result_array();
        
        $this->load->view('label_list', $data);
    }
    
    public function settings()
    {
        $data['title'] = _l('settings');
        $data['login_path'] = $this->login_path;
        $data['info'] = $this->db2->get_where('tbllabels_client', ['module_id' => module_id()])->row_array();
        
        $this->load->view('settings', $data);
    }

    public function login()
    {
        $input = $this->input->post();
        $own = $this->db2->get_where('tbllabels_client', ['module_id' => module_id()])->row_array();
        
        if(isset($own) && $own['e-mail'] == $input['email']){
            set_alert('danger', _l('qr_logged_in'));
        }
        
        $login_user = $this->db2->get_where('tbllabels_client', ['e-mail' => $input['email']])->row_array();
        
        if(isset($login_user)){
            if($login_user['password'] == $input['password']){
                if(!file_exists($this->login_path)){
                    file_put_contents($this->login_path, $login_user['module_id']);
                    set_alert('success', _l('qr_login_success'));
                }
            } else {
                set_alert('danger', _l('qr_login_fail'));
            }
        } else {
            set_alert('danger', _l('qr_login_fail'));
        }
        
        redirect(admin_url('qr_labels/settings'));
    }

    public function logout()
    {
        if(file_exists($this->login_path)){
            if (unlink($this->login_path)) {
                set_alert('success', _l('qr_logout_success'));
            }
        } else {
            set_alert('danger', _l('qr_logout_error'));
        }
        redirect(admin_url('qr_labels/settings'));
    }

    public function add_label()
    {
        $input = $this->input->post();
        
        if ($input['label_id'] > 0) {
            $label = $this->db2->get_where(db_prefix() . 'labels', ['id' => $input['label_id'], 'module_id' => module_id()])->row();
            $image_1 = $label->Pic1;
            $image_2 = $label->Pic2;
            $image_3 = $label->Pic3;
        } else {
            $image_1 = '';
            $image_2 = '';
            $image_3 = '';
        }

        // Handle file uploads
        $config = [
            'upload_path' => 'modules/qr_labels/upload/',
            'allowed_types' => 'jpeg|jpg|png|gif|webp',
            'encrypt_name' => true
        ];
        
        $this->load->library('upload', $config);
        
        // Process each image upload
        for($i = 1; $i <= 3; $i++) {
            $file = $_FILES['file_'.$i]['name'];
            if (!empty($file)) {
                if ($this->upload->do_upload('file_'.$i)) {
                    ${'image_'.$i} = $this->upload->data('file_name');
                    if ($input['label_id'] > 0 && !empty($label->{'Pic'.$i})) {
                        if (file_exists($config['upload_path'] . $label->{'Pic'.$i})) {
                            unlink($config['upload_path'] . $label->{'Pic'.$i});
                        }
                    }
                }
            }
        }

        $insert_data = [
            'name' => $input['wine_name'],
            'BottleSize' => $input['label_bottle'],
            'grapev' => $input['grape_variety'],
            'vintage' => $input['vintage'],
            'alcohol' => $input['alcohol'],
            'serving' => $input['serve_to'],
            'description' => $input['description'],
            'characteristics' => $input['characteristics'],
            'Tcolor' => $input['color'],
            'Ttaste' => $input['scent_taste'],
            'Tpairing' => $input['pairing'],
            'lot' => $input['lot'],
            'date_created' => date('Y-m-d H:i:s'),
            'status' => "0",
            'ID_producer' => qr_producer_id(),
            'module_id' => module_id(),
            'Pic1' => $image_1,
            'Pic2' => $image_2,
            'Pic3' => $image_3,
        ];

        if(file_exists($this->login_path)){
            $insert_data['submit_url'] = base_url();
        }

        if ($input['label_id'] == '0') {
            $this->db2->insert(db_prefix() . 'labels', $insert_data);
            $new_id = $this->db2->insert_id();
            qr_label_id_change($new_id);
            echo json_encode(['alert' => 'success', 'message' => 'Label added successfully']);
        } else {
            $this->db2->where('module_id', module_id());
            $this->db2->where('id', $input['label_id']);
            $this->db2->update(db_prefix() . 'labels', $insert_data);
            echo json_encode(['alert' => 'success', 'message' => 'Label updated successfully']);
        }
    }

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

        $nutrition = $this->db2->get_where(db_prefix() . 'labels_nutrition', ['id_label' => $input['id_label_nutrition']])->row();
        
        if (empty($nutrition)) {
            $insert_data['module_id'] = module_id();
            $insert_data['id_label'] = $input['id_label_nutrition'];
            $this->db2->insert(db_prefix() . 'labels_nutrition', $insert_data);
        } else {
            $this->db2->where('id_label', $input['id_label_nutrition']);
            $this->db2->where('module_id', module_id());
            $this->db2->update(db_prefix() . 'labels_nutrition', $insert_data);
        }

        echo json_encode(['alert' => 'success', 'message' => 'Nutrition information saved successfully']);
    }

    public function add_certification()
    {
        $input = $this->input->post();
        
        $insert_data = [
            'label_id' => $input['label_id_certification'],
            'cert_i_1' => $input['cert_i_1'] ?? 0,
            'cert_i_2' => $input['cert_i_2'] ?? 0,
            'cert_i_3' => $input['cert_i_3'] ?? 0,
            'cert_eu_1' => $input['cert_eu_1'] ?? 0,
            'cert_eu_2' => $input['cert_eu_2'] ?? 0,
            'cert_eu_3' => $input['cert_eu_3'] ?? 0,
            'module_id' => module_id()
        ];
        
        $cert = $this->db2->get_where(db_prefix() . 'labels_cert', ['label_id' => $input['label_id_certification'], 'module_id' => module_id()])->row();
        
        if (empty($cert)) {
            $this->db2->insert(db_prefix() . 'labels_cert', $insert_data);
        } else {
            $this->db2->where('label_id', $input['label_id_certification']);
            $this->db2->where('module_id', module_id());
            $this->db2->update(db_prefix() . 'labels_cert', $insert_data);
        }

        echo json_encode(['alert' => 'success', 'message' => 'Certifications saved successfully']);
    }

    public function add_recycling()
    {
        $input = $this->input->post();
        
        $insert_data = [
            'label_id' => $input['label_id'],
            'bottle_id' => $input['label_bottle'] ?? null,
            'cork_id' => $input['label_cork'] ?? null,
            'capsule_id' => $input['label_capsule'] ?? null,
            'cork_cage_id' => $input['label_cage'] ?? null,
            'packaging_id' => $input['label_container'] ?? null,
        ];
        
        $recycling = $this->db2->get_where(db_prefix() . 'labels_recycling_relation', ['label_id' => $input['label_id']])->row();
        
        if (empty($recycling)) {
            $this->db2->insert(db_prefix() . 'labels_recycling_relation', $insert_data);
        } else {
            $this->db2->where('label_id', $input['label_id']);
            $this->db2->update(db_prefix() . 'labels_recycling_relation', $insert_data);
        }

        echo json_encode(['alert' => 'success', 'message' => 'Recycling information saved successfully']);
    }

    public function generate_qr_code($id)
    {
        $label = $this->db2->get_where(db_prefix() . 'labels', ['id' => $id])->row();
        
        if(isset($label) && $label->ID_producer != 0 ){
            $name = $this->db2->get_where(db_prefix() . 'labels_client', ['id' => $label->ID_producer])->row_array();
            if(!empty($name)){
                echo json_encode(['status' => true, 'message' => '', 'name' => $name['url-label'], 'label_id' => $label->label_id]);
                die;
            }
        }
        echo json_encode(['status' => false, 'message' => 'Producer Name not found']);
    }

    public function publish_label($id)
    {
        $this->db2->where('id', $id);
        $this->db2->where('module_id', module_id());
        $this->db2->update(db_prefix() . 'labels', [
            'status' => 1,
            'date_published' => date('Y-m-d H:i:s')
        ]);
        
        set_alert('success', 'Label published successfully.');
        redirect(admin_url('qr_labels/label_list'));
    }

    public function delete_label($id)
    {
        $this->db2->where('id', $id);
        $this->db2->where('module_id', module_id());
        $this->db2->update(db_prefix() . 'labels', ['is_delete' => 1]);
        
        set_alert('success', 'Label deleted successfully.');
        redirect(admin_url('qr_labels/label_list'));
    }

    public function duplicate_label($id)
    {
        $label = $this->db2->get_where(db_prefix() . 'labels', ['id' => $id, 'module_id' => module_id()])->row();
        
        if($label) {
            $insert_data = [
                'name' => $label->name . ' (COPY)',
                'grapev' => $label->grapev,
                'vintage' => $label->vintage,
                'alcohol' => $label->alcohol,
                'serving' => $label->serving,
                'description' => $label->description,
                'characteristics' => $label->characteristics,
                'Tcolor' => $label->Tcolor,
                'Ttaste' => $label->Ttaste,
                'Tpairing' => $label->Tpairing,
                'Pic1' => $label->Pic1,
                'Pic2' => $label->Pic2,
                'Pic3' => $label->Pic3,
                'date_created' => date('Y-m-d H:i:s'),
                'status' => "0",
                'ID_producer' => qr_producer_id(),
                'module_id' => module_id()
            ];
            
            $this->db2->insert(db_prefix() . 'labels', $insert_data);
            $new_id = $this->db2->insert_id();
            qr_label_id_change($new_id);
            
            set_alert('success', 'Label duplicated successfully.');
        }
        
        redirect(admin_url('qr_labels/label_list'));
    }

    public function table($table)
    {
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path(QR_labels, 'common/table/' . $table));
        }
    }
}
