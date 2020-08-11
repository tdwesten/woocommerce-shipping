<?php

require_once('vendor/autoload.php');

/**
 * Plugin Name: DPD Connect for WooCommerce
 * Plugin URI: http://www.dpd.nl
 * Description: Enables the posibility to integrate DPD Parcel Shop Finder service into your e-commerce store with a breeze.
 * Version: 1.0
 * Author: DPD / X-Interactive.nl
 * Author URI: https://github.com/dpdconnect
 * License: GPL
 * Text Domain: dpdconnect
 * Domain Path: /languages
 */

use DpdConnect\classes\Router;
use DpdConnect\classes\Handlers\Assets;
use DpdConnect\classes\Handlers\Notice;
use DpdConnect\classes\Handlers\Pickup;
use DpdConnect\classes\Settings\Handler;
use DpdConnect\classes\Handlers\Activate;
use DpdConnect\classes\Handlers\Callback;
use DpdConnect\classes\Handlers\OrderColumn;
use DpdConnect\classes\Handlers\Translation;
use DpdConnect\classes\Handlers\LabelRequest;
use DpdConnect\classes\Handlers\DownloadLabelBox;
use DpdConnect\classes\Handlers\OrderListActions;
use DpdConnect\classes\Handlers\ShippingMethods;
use DpdConnect\classes\Handlers\GenerateLabelBox;
use DpdConnect\classes\Handlers\ShippingAttributes;

// Prevent direct file access
defined('ABSPATH') or exit;

// SET Root path
define('DPDCONNECT_PLUGIN_ROOT_PATH', plugin_dir_path(__FILE__));

// Add tables for storing labels
Activate::handle();

// Load available translations
add_action('plugins_loaded', [Translation::class, 'handle']);

/**
 * Check if WooCommerce is active
 */
if (is_plugin_active('woocommerce/woocommerce.php')) {

    /**
     * Add settings admin menu
     */
    Handler::handle();

    /**
     * Load assets
     */
    Assets::handle();

    /**
     * Add Admin ShopOrder metaBoxes
     */
    GenerateLabelBox::handle();
    DownloadLabelBox::handle();

    /**
     * Add DPD Pickup functionality
     */
    Pickup::handle();

    /**
     * Add Admin Product attributes for Customs
     */
    ShippingAttributes::handle();

    /**
     * Add shipping methods and classes
     */
    ShippingMethods::handle();

    /**
     * Add functions for notifications
     */
    Notice::handle();

    /**
     * Add DPD Order Bulk Actions functionality
     */
    LabelRequest::handle();

    /**
     * Listen for incoming callbacks
     */
    Callback::handle();

    /**
     * Add column to WooCommerce order table
     */
    OrderColumn::handle();

    /**
     * Initiate router
     */
    Router::init($_GET);
 
    /**
     * Add bulk actions to woocommerce order table
     */
    OrderListActions::handle();
}