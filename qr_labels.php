<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: QR Labels
Description: Wine QR Labels Genarator
Version: 1.0.0
Requires at least: 2.3.*
*/


define('QR_labels', 'qr_labels');
define('QRURL', 'https://digi-card.net/');

hooks()->add_action('admin_init', 'qr_labels_init_menu_items');

/**
 * Register activation module hook
 */
register_activation_hook(QR_labels, 'qr_labels_activation_hook');

function qr_labels_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}
$CI = &get_instance();
$CI->load->helper(QR_labels . '/qr_labels');
/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(QR_labels, [QR_labels]);

/**
 * Init backup module menu items in setup in admin_init hook
 * @return null
 */
function qr_labels_init_menu_items()
{
    if (is_admin()) {
        $CI = &get_instance();

        $CI->app_menu->add_sidebar_menu_item('template_menu', [
            'name'     => _l('QR Labels'),
            'icon'     => 'fa fa-file',
            'position' => 5,
        ]);

        $CI->app_menu->add_sidebar_children_item('template_menu', [
            'slug'     => 'child_qr_label',
            'name'     => _l('dashboard_string'),
            'href'     => admin_url('qr_labels/dashboard'),
            'position' => 1,
        ]);

        $CI->app_menu->add_sidebar_children_item('template_menu', [
            'slug'     => 'child_qr_label',
            'name'     => _l('qr_label_list'),
            'href'     => admin_url('qr_labels/label_list'),
            'position' => 5, 
        ]);
        $CI->app_menu->add_sidebar_children_item('template_menu', [
            'slug'     => 'child_qr_label',
            'name'     => _l('settings'), 
            'href'     => admin_url('qr_labels/settings'),
            'position' => 10, 
        ]);
    }
}
