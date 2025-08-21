<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: QR Wine Label by BIT SOLUTIONS
Description: Professional wine QR label generator with certification management, nutrition tracking, and recycling information for wine industry professionals.
Version: 1.0
Author: BIT SOLUTIONS
Author URI: https://bitsolutions.com
Requires at least: 2.3.*
*/

define('QR_WINE_MODULE_NAME', 'qrwine');
define('QR_WINE_MODULE_VERSION', '1.0');

hooks()->add_action('admin_init', 'qrwine_module_init_menu_items');
hooks()->add_action('app_admin_head', 'qrwine_add_head_components');

/**
 * Register activation module hook
 */
register_activation_hook(QR_WINE_MODULE_NAME, 'qrwine_module_activation_hook');

function qrwine_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(QR_WINE_MODULE_NAME, [QR_WINE_MODULE_NAME]);

/**
 * Init module menu items in setup in admin_init hook
 * @return null
 */
function qrwine_module_init_menu_items()
{
    $CI = &get_instance();

    if (is_admin() || has_permission('qrwine', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('qrwine', [
            'name'     => 'QR Wine Labels',
            'href'     => admin_url('qrwine'),
            'position' => 35,
            'icon'     => 'fa fa-qrcode',
            'badge'    => [],
        ]);

        $CI->app_menu->add_sidebar_children_item('qrwine', [
            'slug'     => 'qrwine-dashboard',
            'name'     => 'Dashboard',
            'href'     => admin_url('qrwine'),
            'position' => 1,
        ]);

        $CI->app_menu->add_sidebar_children_item('qrwine', [
            'slug'     => 'qrwine-labels',
            'name'     => 'Wine Labels',
            'href'     => admin_url('qrwine/manage'),
            'position' => 2,
        ]);

        $CI->app_menu->add_sidebar_children_item('qrwine', [
            'slug'     => 'qrwine-settings',
            'name'     => 'Settings',
            'href'     => admin_url('qrwine/settings'),
            'position' => 3,
        ]);
    }
}

/**
 * Add additional CSS and JS files
 */
function qrwine_add_head_components()
{
    $CI = &get_instance();
    $viewuri = $_SERVER['REQUEST_URI'];
    
    if (!(strpos($viewuri, '/admin/qrwine') === false)) {
        echo '<link href="' . module_dir_url(QR_WINE_MODULE_NAME, 'assets/css/qrwine.css') . '" rel="stylesheet" type="text/css" />';
        echo '<script src="' . module_dir_url(QR_WINE_MODULE_NAME, 'assets/js/qrwine.js') . '"></script>';
    }
}
