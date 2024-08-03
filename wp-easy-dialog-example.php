<?php
/**
 * Plugin Name:       WP Easy Dialog Example
 * Description:       Example usage of WP Easy Dialog.
 * Requires at least: 5.0
 * Requires PHP:      8.0
 * Version:           1.0.0
 * Author:            Thomas Zwirner
 * Author URI:        https://www.thomaszwirner.de
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-easy-dialog-example
 *
 * @package wp-easy-dialog-example
 */

/**
 * Add WP Dialog Easy scripts in wp-admin.
 */
add_action( 'admin_enqueue_scripts', 'custom_dialog_embed' );
function custom_dialog_embed(): void {
    // define paths: adjust if necessary.
    $path = trailingslashit(plugin_dir_path(__FILE__)).'vendor/threadi/wp-easy-dialog/';
    $url = trailingslashit(plugin_dir_url(__FILE__)).'vendor/threadi/wp-easy-dialog/';

    // bail if path does not exist.
    if( !file_exists($path) ) {
        return;
    }

    // get assets path.
    $script_asset_path = $path . 'build/index.asset.php';

    // bail if assets does not exist.
    if( !file_exists($script_asset_path) ) {
        return;
    }

    // embed the dialog-components JS-script.
    $script_asset      = require( $script_asset_path );
    wp_enqueue_script(
        'wp-easy-dialog',
        $url . 'build/index.js',
        $script_asset['dependencies'],
        $script_asset['version'],
        true
    );

    // embed the dialog-components CSS-script.
    $admin_css      = $url . 'build/style-index.css';
    $admin_css_path = $path . 'build/style-index.css';
    wp_enqueue_style(
        'wp-easy-dialog',
        $admin_css,
        array( 'wp-components' ),
        filemtime( $admin_css_path )
    );
}

/**
 * Add a new dashboard widget.
 *
 * @return void
 */
function wp_easy_dialog_add_dashboard_widgets(): void {
    wp_add_dashboard_widget(
        'dashboard_widget',
        __( 'WP Easy Dialog Example', 'wp-easy-dialog' ),
        'wp_easy_dialog_dashboard_widget_function',
        null,
        null,
        'normal',
        'high'
    );
}
add_action( 'wp_dashboard_setup', 'wp_easy_dialog_add_dashboard_widgets' );

/**
 * Output the contents of the dashboard widget.
 *
 * @param $post
 * @param $callback_args
 * @return void
 */
function wp_easy_dialog_dashboard_widget_function( $post, $callback_args ): void {
    $dialog = array(
        'title' => 'My title',
        'texts' => array(
            '<p>My text</p>'
        ),
        'buttons' => array(
            array(
                'action' => 'alert("ok");',
                'variant' => 'primary',
                'text' => 'Click here'
            ),
        )
    );
    echo '<a href="#" class="wp-easy-dialog" data-dialog="'.esc_attr(wp_json_encode($dialog)).'">Some link</a>';
}