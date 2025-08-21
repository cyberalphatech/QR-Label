<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * QR Wine Label Helper Functions
 * Version: 1.0
 */

if (!function_exists('generate_wine_qr_code')) {
    /**
     * Generate QR code for wine label using external API
     */
    function generate_wine_qr_code($wine_data)
    {
        $api_url = 'https://digi-card.net/cron.php';
        
        $post_data = array(
            'wine_name' => $wine_data['name'],
            'producer' => $wine_data['client_name'],
            'vintage' => $wine_data['vintage'],
            'alcohol' => $wine_data['alcohol'],
            'lot' => $wine_data['lot'],
            'grape_variety' => $wine_data['grape_variety']
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Host: digi-card.net'
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200 && $response) {
            $result = json_decode($response, true);
            return isset($result['qr_url']) ? $result['qr_url'] : false;
        }

        return false;
    }
}

if (!function_exists('format_wine_alcohol')) {
    /**
     * Format alcohol percentage for display
     */
    function format_wine_alcohol($alcohol)
    {
        return number_format($alcohol, 1) . '%';
    }
}

if (!function_exists('get_wine_certification_badge')) {
    /**
     * Get certification badge HTML
     */
    function get_wine_certification_badge($cert_type)
    {
        $badges = array(
            'DOC' => '<span class="badge badge-primary">DOC</span>',
            'DOCG' => '<span class="badge badge-success">DOCG</span>',
            'IGT' => '<span class="badge badge-info">IGT</span>',
            'EU_ORGANIC' => '<span class="badge badge-success">EU Organic</span>',
            'EU_DOP' => '<span class="badge badge-warning">DOP</span>',
            'EU_IGP' => '<span class="badge badge-secondary">IGP</span>',
            'EU_STG' => '<span class="badge badge-dark">STG</span>'
        );

        return isset($badges[$cert_type]) ? $badges[$cert_type] : '<span class="badge badge-light">' . $cert_type . '</span>';
    }
}

if (!function_exists('get_wine_status_badge')) {
    /**
     * Get status badge HTML
     */
    function get_wine_status_badge($status)
    {
        if ($status == 1) {
            return '<span class="badge badge-success">Published</span>';
        } else {
            return '<span class="badge badge-secondary">Draft</span>';
        }
    }
}
