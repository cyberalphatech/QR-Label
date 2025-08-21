<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * QR Wine Label Model
 * Handles database operations for wine labels using external database
 */
class Qrwine_model extends App_Model
{
    private $db2; // External database connection
    
    public function __construct()
    {
        parent::__construct();
        
        // Load external database configuration
        $this->db2 = $this->load->database('db2', TRUE);
    }

    /**
     * Get total number of wine labels
     */
    public function get_total_labels()
    {
        $count = $this->db2->count_all('tbllabels');
        return is_numeric($count) ? (int)$count : 0;
    }

    /**
     * Get count of published labels
     */
    public function get_published_labels_count()
    {
        $this->db2->where('status', 1);
        $count = $this->db2->count_all_results('tbllabels');
        return is_numeric($count) ? (int)$count : 0;
    }

    /**
     * Get count of draft labels
     */
    public function get_draft_labels_count()
    {
        $this->db2->where('status', 0);
        $count = $this->db2->count_all_results('tbllabels');
        return is_numeric($count) ? (int)$count : 0;
    }

    /**
     * Get count of labels with QR codes generated
     */
    public function get_qr_codes_count()
    {
        $this->db2->where('date_published IS NOT NULL');
        $count = $this->db2->count_all_results('tbllabels');
        return is_numeric($count) ? (int)$count : 0;
    }

    /**
     * Get recent wine labels
     */
    public function get_recent_labels($limit = 5)
    {
        $this->db2->select('l.*, c.name as client_name, d.name as bottle_name');
        $this->db2->from('tbllabels l');
        $this->db2->join('tbllabels_client c', 'l.ID_producer = c.id', 'left');
        $this->db2->join('tbldropdown_list d', 'l.BottleSize = d.id', 'left');
        $this->db2->order_by('l.date_created', 'DESC');
        $this->db2->limit($limit);
        
        $result = $this->db2->get()->result();
        return is_array($result) ? $result : array();
    }

    /**
     * Get wine labels with pagination and filters
     */
    public function get_wine_labels_paginated($per_page, $offset, $search = null, $status_filter = null, $producer_filter = null)
    {
        $this->db2->select('l.*, c.name as producer_name, d.name as bottle_name');
        $this->db2->from('tbllabels l');
        $this->db2->join('tbllabels_client c', 'l.ID_producer = c.id', 'left');
        $this->db2->join('tbldropdown_list d', 'l.BottleSize = d.id', 'left');
        
        // Apply filters
        if (!empty($search)) {
            $this->db2->group_start();
            $this->db2->like('l.name', $search);
            $this->db2->or_like('l.grapev', $search);
            $this->db2->or_like('l.lot', $search);
            $this->db2->or_like('c.name', $search);
            $this->db2->group_end();
        }
        
        if (!empty($status_filter)) {
            if ($status_filter == 'published') {
                $this->db2->where('l.status', 1);
            } elseif ($status_filter == 'draft') {
                $this->db2->where('l.status', 0);
            }
        }
        
        if (!empty($producer_filter) && is_numeric($producer_filter)) {
            $this->db2->where('l.ID_producer', $producer_filter);
        }
        
        $this->db2->order_by('l.date_created', 'DESC');
        $this->db2->limit($per_page, $offset);
        
        $result = $this->db2->get()->result();
        return is_array($result) ? $result : array();
    }

    /**
     * Get count of wine labels with filters
     */
    public function get_wine_labels_count($search = null, $status_filter = null, $producer_filter = null)
    {
        $this->db2->from('tbllabels l');
        $this->db2->join('tbllabels_client c', 'l.ID_producer = c.id', 'left');
        
        // Apply same filters as pagination method
        if (!empty($search)) {
            $this->db2->group_start();
            $this->db2->like('l.name', $search);
            $this->db2->or_like('l.grapev', $search);
            $this->db2->or_like('l.lot', $search);
            $this->db2->or_like('c.name', $search);
            $this->db2->group_end();
        }
        
        if (!empty($status_filter)) {
            if ($status_filter == 'published') {
                $this->db2->where('l.status', 1);
            } elseif ($status_filter == 'draft') {
                $this->db2->where('l.status', 0);
            }
        }
        
        if (!empty($producer_filter) && is_numeric($producer_filter)) {
            $this->db2->where('l.ID_producer', $producer_filter);
        }
        
        $count = $this->db2->count_all_results();
        return is_numeric($count) ? (int)$count : 0;
    }

    /**
     * Get all producers for filter dropdown
     */
    public function get_all_producers()
    {
        $this->db2->select('id, name');
        $this->db2->from('tbllabels_client');
        $this->db2->where('status', 1);
        $this->db2->order_by('name', 'ASC');
        
        $result = $this->db2->get()->result();
        return is_array($result) ? $result : array();
    }

    /**
     * Get wine label by ID
     */
    public function get($id)
    {
        $this->db2->select('l.*, c.name as client_name, c.address as client_address');
        $this->db2->from('tbllabels l');
        $this->db2->join('tbllabels_client c', 'l.ID_producer = c.id', 'left');
        $this->db2->where('l.label_id', $id);
        
        $result = $this->db2->get()->row();
        
        if ($result) {
            // Get nutrition information
            $this->db2->where('label_id', $id);
            $result->nutrition = $this->db2->get('tbllabels_nutrition')->row();
            
            // Get certifications
            $this->db2->where('label_id', $id);
            $result->certifications = $this->db2->get('tbllabels_cert')->result();
            
            // Get recycling information
            $this->db2->select('r.*, rr.component_type');
            $this->db2->from('tbllabels_recycling r');
            $this->db2->join('tbllabels_recycling_relation rr', 'r.recycling_id = rr.recycling_id');
            $this->db2->where('rr.label_id', $id);
            $result->recycling = $this->db2->get()->result();
        }
        
        return $result;
    }

    /**
     * Add new wine label
     */
    public function add($data)
    {
        // Prepare main label data
        $label_data = array(
            'name' => $data['name'],
            'lot' => $data['lot'],
            'grapev' => $data['grape_variety'],
            'vintage' => $data['vintage'],
            'alcohol' => $data['alcohol'],
            'serving' => $data['serving_temperature'],
            'BottleSize' => $data['bottle_size'],
            'ID_producer' => $data['client_id'],
            'date_created' => date('Y-m-d H:i:s'),
            'status' => isset($data['status']) ? $data['status'] : 0
        );

        $this->db2->insert('tbllabels', $label_data);
        $label_id = $this->db2->insert_id();

        if ($label_id) {
            // Add nutrition information if provided
            if (isset($data['nutrition'])) {
                $nutrition_data = $data['nutrition'];
                $nutrition_data['label_id'] = $label_id;
                $this->db2->insert('tbllabels_nutrition', $nutrition_data);
            }

            // Add certifications if provided
            if (isset($data['certifications']) && is_array($data['certifications'])) {
                foreach ($data['certifications'] as $cert) {
                    $cert_data = array(
                        'label_id' => $label_id,
                        'certification_type' => $cert,
                        'date_created' => date('Y-m-d H:i:s')
                    );
                    $this->db2->insert('tbllabels_cert', $cert_data);
                }
            }

            // Add recycling information if provided
            if (isset($data['recycling']) && is_array($data['recycling'])) {
                foreach ($data['recycling'] as $component_type => $component_id) {
                    if (!empty($component_id) && is_numeric($component_id)) {
                        $relation_data = array(
                            'label_id' => $label_id,
                            'recycling_id' => $component_id,
                            'component_type' => $component_type,
                            'date_created' => date('Y-m-d H:i:s')
                        );
                        $this->db2->insert('tbllabels_recycling_relation', $relation_data);
                    }
                }
            }
        }

        return $label_id;
    }

    /**
     * Update wine label
     */
    public function update($data, $id)
    {
        // Prepare main label data
        $label_data = array();
        
        if (isset($data['name'])) $label_data['name'] = $data['name'];
        if (isset($data['lot'])) $label_data['lot'] = $data['lot'];
        if (isset($data['grape_variety'])) $label_data['grapev'] = $data['grape_variety'];
        if (isset($data['vintage'])) $label_data['vintage'] = $data['vintage'];
        if (isset($data['alcohol'])) $label_data['alcohol'] = $data['alcohol'];
        if (isset($data['serving_temperature'])) $label_data['serving'] = $data['serving_temperature'];
        if (isset($data['bottle_size'])) $label_data['BottleSize'] = $data['bottle_size'];
        if (isset($data['status'])) $label_data['status'] = $data['status'];
        if (isset($data['qr_code'])) $label_data['qr_code'] = $data['qr_code'];

        $label_data['date_updated'] = date('Y-m-d H:i:s');

        $this->db2->where('label_id', $id);
        $success = $this->db2->update('tbllabels', $label_data);

        // Update nutrition information if provided
        if (isset($data['nutrition'])) {
            $this->db2->where('label_id', $id);
            if ($this->db2->count_all_results('tbllabels_nutrition') > 0) {
                $this->db2->where('label_id', $id);
                $this->db2->update('tbllabels_nutrition', $data['nutrition']);
            } else {
                $nutrition_data = $data['nutrition'];
                $nutrition_data['label_id'] = $id;
                $this->db2->insert('tbllabels_nutrition', $nutrition_data);
            }
        }

        // Update certifications if provided
        if (isset($data['certifications']) && is_array($data['certifications'])) {
            $this->db2->where('label_id', $id);
            $this->db2->delete('tbllabels_cert');
            foreach ($data['certifications'] as $cert) {
                $cert_data = array(
                    'label_id' => $id,
                    'certification_type' => $cert,
                    'date_created' => date('Y-m-d H:i:s')
                );
                $this->db2->insert('tbllabels_cert', $cert_data);
            }
        }

        // Update recycling information if provided
        if (isset($data['recycling']) && is_array($data['recycling'])) {
            $this->update_recycling($id, $data['recycling']);
        }

        return $success;
    }

    /**
     * Delete wine label
     */
    public function delete($id)
    {
        // Delete related records first
        $this->db2->where('label_id', $id);
        $this->db2->delete('tbllabels_nutrition');
        
        $this->db2->where('label_id', $id);
        $this->db2->delete('tbllabels_cert');
        
        $this->db2->where('label_id', $id);
        $this->db2->delete('tbllabels_recycling_relation');

        // Delete main label record
        $this->db2->where('label_id', $id);
        return $this->db2->delete('tbllabels');
    }

    /**
     * Get all wine labels for datatables
     */
    public function get_wine_labels($aColumns, $sIndexColumn, $sTable, $join = array(), $where = array(), $additionalSelect = array())
    {
        $this->db2->select('l.label_id, l.name, l.lot, l.vintage, l.alcohol, l.status, l.date_created, c.name as client_name, d.name as bottle_name');
        $this->db2->from('tbllabels l');
        $this->db2->join('tbllabels_client c', 'l.ID_producer = c.id', 'left');
        $this->db2->join('tbldropdown_list d', 'l.BottleSize = d.id', 'left');
        
        return $this->db2->get()->result_array();
    }

    /**
     * Get dropdown lists (bottle sizes, etc.) - FIXED METHOD
     */
    public function get_dropdown_list($type)
    {
        if (empty($type)) {
            return array();
        }
        
        $this->db2->where('type', $type);
        $result = $this->db2->get('tbldropdown_list')->result();
        return is_array($result) ? $result : array();
    }

    /**
     * Get clients/producers
     */
    public function get_clients()
    {
        $this->db2->where('status', 1);
        return $this->db2->get('tbllabels_client')->result();
    }

    /**
     * Get business information for current user/client
     */
    public function get_business_info($client_id = null)
    {
        if ($client_id && is_numeric($client_id)) {
            $this->db2->where('id', $client_id);
        }
        $this->db2->limit(1);
        $result = $this->db2->get('tbllabels_client')->row();
        return $result ? $result : (object)array();
    }

    /**
     * Save business information (create or update) - FIXED METHOD
     */
    public function save_business_info($data)
    {
        if (isset($data['id']) && is_numeric($data['id']) && $data['id'] > 0) {
            return $this->update_business_info($data, $data['id']);
        } else {
            return $this->create_business_info($data);
        }
    }

    /**
     * Update business information
     */
    public function update_business_info($data, $client_id)
    {
        $this->db2->where('id', $client_id);
        return $this->db2->update('tbllabels_client', $data);
    }

    /**
     * Create new business information
     */
    public function create_business_info($data)
    {
        $data['date_created'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        $this->db2->insert('tbllabels_client', $data);
        return $this->db2->insert_id();
    }

    /**
     * Update recycling information for wine label
     */
    public function update_recycling($label_id, $recycling_data)
    {
        if (!is_numeric($label_id) || $label_id <= 0) {
            return false;
        }
        
        // First, delete existing recycling relations for this label
        $this->db2->where('label_id', $label_id);
        $this->db2->delete('tbllabels_recycling_relation');
        
        // Insert new recycling information
        $success = true;
        foreach ($recycling_data as $component_type => $component_id) {
            if (!empty($component_id) && is_numeric($component_id)) {
                $relation_data = array(
                    'label_id' => $label_id,
                    'recycling_id' => $component_id,
                    'component_type' => $component_type,
                    'date_created' => date('Y-m-d H:i:s')
                );
                
                if (!$this->db2->insert('tbllabels_recycling_relation', $relation_data)) {
                    $success = false;
                }
            }
        }
        
        return $success;
    }

    /**
     * Get nutrition data for wine label
     */
    public function get_nutrition_data($label_id)
    {
        if (!is_numeric($label_id) || $label_id <= 0) {
            return null;
        }
        
        $this->db2->where('label_id', $label_id);
        $result = $this->db2->get('tbllabels_nutrition')->row();
        
        return $result ? $result : null;
    }

    /**
     * Save nutrition data for wine label (create or update)
     */
    public function save_nutrition_data($label_id, $nutrition_data)
    {
        if (!is_numeric($label_id) || $label_id <= 0) {
            return false;
        }
        
        // Check if nutrition data already exists
        $this->db2->where('label_id', $label_id);
        $existing = $this->db2->get('tbllabels_nutrition')->row();
        
        if ($existing) {
            // Update existing record
            $this->db2->where('label_id', $label_id);
            return $this->db2->update('tbllabels_nutrition', $nutrition_data);
        } else {
            // Create new record
            $nutrition_data['label_id'] = $label_id;
            $nutrition_data['date_created'] = date('Y-m-d H:i:s');
            return $this->db2->insert('tbllabels_nutrition', $nutrition_data);
        }
    }
}
