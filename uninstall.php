<?php
/**
 * Tasks to run during uninstallation of this plugin.
 *
 * @package wp-easy-dialog-example
 */

// if uninstall.php is not called by WordPress, die.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// prevent also other direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// nothing to do.
