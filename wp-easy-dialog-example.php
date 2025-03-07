<?php
/**
 * Plugin Name:       Easy Block Dialog for WordPress Example
 * Description:       Example usage of Easy Block Dialog for WordPress.
 * Requires at least: 5.0
 * Requires PHP:      8.0
 * Version:           1.1.0
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
add_action( 'admin_enqueue_scripts', 'edfw_example_dialog_embed' );
function edfw_example_dialog_embed(): void {
    // define paths: adjust if necessary.
    $path = trailingslashit(plugin_dir_path(__FILE__)).'vendor/threadi/easy-dialog-for-wordpress/';
    $url = trailingslashit(plugin_dir_url(__FILE__)).'vendor/threadi/easy-dialog-for-wordpress/';

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
        'easy_dialog_dashboard_widget',
        __( 'Easy Dialog for WordPress Example', 'wp-easy-dialog-example' ),
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
    // create dialog #1.
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

    // create dialog #2.
    $dialog2 = array(
        'id' => 'dialog2',
        'title' => 'My title 2',
        'texts' => array(
            '<p>My text 2</p>'
        ),
        'buttons' => array(
            array(
                'action' => 'alert("ok2");',
                'variant' => 'primary',
                'text' => 'Click here'
            ),
        )
    );

    // create dialog #3.
    $dialog3 = array(
        'title' => 'My title 3',
        'texts' => array(
            '<p>My text 3</p>'
        ),
        'buttons' => array(
            array(
                'action' => 'edfw_open_dialog("dialog2");',
                'variant' => 'primary',
                'text' => 'Click here'
            ),
        )
    );

    // define dialog settings.
    $dialog_settings = array(
        'shouldCloseOnEsc' => true
    );
    echo '<a href="#" class="easy-dialog-for-wordpress" data-dialog="'.esc_attr(wp_json_encode($dialog)).'" data-dialog-settings="'.esc_attr(wp_json_encode($dialog_settings)).'">' . __( 'Dialog 1', 'wp-easy-dialog-example' ) .  '</a><br>';
    echo '<a href="#" class="easy-dialog-for-wordpress" data-dialog="'.esc_attr(wp_json_encode($dialog2)).'" data-dialog-settings="'.esc_attr(wp_json_encode($dialog_settings)).'">' . __( 'Dialog 2', 'wp-easy-dialog-example' ) .  '</a><br>';
    echo '<a href="#" class="easy-dialog-for-wordpress" data-dialog="'.esc_attr(wp_json_encode($dialog3)).'" data-dialog-settings="'.esc_attr(wp_json_encode($dialog_settings)).'">' . __( 'Open Dialog 2 via button (first open Button 2, than this one)', 'wp-easy-dialog-example' ) .  '</a>';
}