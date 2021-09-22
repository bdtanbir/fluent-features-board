<?php
namespace FFB;

/**
 * Admin Pages Handler
 */
class FFB_Admin {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register our menu page
     *
     * @return void
     */
    public function admin_menu() {
        $capability = 'manage_options';
        $slug       = 'fluent-features-board';

        $hook = add_menu_page( 
            __( 'Fluent Features Board', 'fluent-features-board' ), 
            __( 'Fluent Features Board', 'fluent-features-board' ), 
            $capability, 
            $slug, 
            [ $this, 'ffb_menu_page_template' ], 
            'dashicons-list-view',
            50
        );

        add_action( 'load-' . $hook, [ $this, 'init_hooks'] );
    }

    /**
     * Initialize our hooks for the admin page
     * @return void
     */
    public function init_hooks() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'fluent-features-board' );
        wp_enqueue_script( 'fluent-features-board' );
    }

    /**
     * Render our admin page
     * @return void
     */
    public function ffb_menu_page_template() {
        echo '<div class="wrap"><div id="fluent-features-board-app"></div></div>';
    }
}
