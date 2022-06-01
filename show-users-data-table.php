<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           shudat
 *
 * @wordpress-plugin
 * Plugin Name:       Show Users Data as Table
 * Plugin URI:        #
 * Description:       A plugin that displays users' data as an HTML table.
 * Version:           1.0.0
 * Author:            Mauriac Azoua
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shudat
 * Domain Path:       /languages
 */

declare(strict_types=1);

namespace Shudat;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

require_once plugin_dir_path(__FILE__) . 'public/ShudatPublic.php';

(new ShudatPublic('shudat', '1.0.0'))->run();
