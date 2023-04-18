<?php
/**
 * Plugin Name:       Isfis Form Plugin
 * Description:       Agrega la posibilidad de crear formularios.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            DM2AGROUP
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       isfis-form-plugin
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_isfis_form_plugin_block_init() {
	register_block_type( __DIR__ . '/build' );
    register_block_type( __DIR__ . '/inputText/build' );
    register_block_type( __DIR__ . '/inputEmail/build' );
    register_block_type( __DIR__ . '/textArea/build' );
}
add_action( 'init', 'create_block_isfis_form_plugin_block_init' );

function filter_block_categories_when_post_provided( $block_categories, $editor_context ) {
    if ( ! empty( $editor_context->post ) ) {
        array_push(
            $block_categories,
            array(
                'slug'  => 'formulario-isfis',
                'title' => __( 'Formulario Isfis', 'isfis-form-plugin' ),
                'icon'  => null,
            )
        );
    }
    return $block_categories;
}

add_filter( 'block_categories_all', 'filter_block_categories_when_post_provided', 10, 2 );
?>