<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Get module ID for current Perfex CRM installation
 */
function module_id()
{
    $CI = &get_instance();
    return get_staff_user_id();
}

/**
 * Get producer ID for current user
 */
function qr_producer_id()
{
    $CI = &get_instance();
    $info = $CI->db2->get_where('tbllabels_client', ['module_id' => module_id()])->row_array();
    return isset($info) ? $info['id'] : 0;
}

/**
 * Get user type
 */
function get_type()
{
    $CI = &get_instance();
    $info = $CI->db2->get_where('tbllabels_client', ['module_id' => module_id()])->row_array();
    return isset($info) ? $info['type'] : false;
}

/**
 * Update label ID after creation
 */
function qr_label_id_change($id)
{
    $CI = &get_instance();
    $CI->db2->where('id', $id);
    $CI->db2->update(db_prefix() . 'labels', ['label_id' => $id]);
}

/**
 * Generate QR code via external API
 */
function generate_qr_code_api($data)
{
    $url = QRURL . 'cron.php';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Host: digi-card.net'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

/**
 * Validate image upload
 */
function validate_wine_image($file)
{
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file['type'], $allowed_types)) {
        return ['status' => false, 'message' => 'Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed.'];
    }
    
    if ($file['size'] > $max_size) {
        return ['status' => false, 'message' => 'File size too large. Maximum 5MB allowed.'];
    }
    
    return ['status' => true, 'message' => 'Valid image file.'];
}

/**
 * Handle tag saving for ingredients, preservatives, etc.
 */
function handle_tags_save($tags_string, $rel_id, $rel_type)
{
    $CI = &get_instance();
    
    // Remove existing tags for this relation
    $CI->db2->where('rel_id', $rel_id);
    $CI->db2->where('rel_type', $rel_type);
    $CI->db2->delete(db_prefix() . 'taggables');
    
    if (!empty($tags_string)) {
        $tags = explode(',', $tags_string);
        
        foreach ($tags as $tag_name) {
            $tag_name = trim($tag_name);
            if (!empty($tag_name)) {
                // Check if tag exists
                $existing_tag = $CI->db2->get_where(db_prefix() . 'tags', ['name' => $tag_name])->row();
                
                if (!$existing_tag) {
                    // Create new tag
                    $CI->db2->insert(db_prefix() . 'tags', ['name' => $tag_name]);
                    $tag_id = $CI->db2->insert_id();
                } else {
                    $tag_id = $existing_tag->id;
                }
                
                // Create tag relation
                $CI->db2->insert(db_prefix() . 'taggables', [
                    'tag_id' => $tag_id,
                    'rel_id' => $rel_id,
                    'rel_type' => $rel_type
                ]);
            }
        }
    }
}

/**
 * Template module image handling
 */
function template_module_images($images)
{
    // Handle image processing for template module
    // This function would integrate with the external template system
    return true;
}
