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
        $submenu = add_submenu_page( 
            $slug, 
            __('Features Request Lists', 'fluent-features-board'), 
            __('Features Request Lists', 'fluent-features-board'),
            $capability, 
            'fluent-request-lists',
            [$this, 'features_request_lists']
        );

        add_action( 'load-' . $hook, [ $this, 'init_hooks'] );
        add_action( 'load-' . $submenu, [ $this, 'init_submenu_hooks'] );
    }

    /**
     * Initialize our hooks for the admin page
     * @return void
     */
    public function init_hooks() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    public function init_submenu_hooks() {
        add_action( 'admin_enqueue_scripts', [ $this, 'ffr_enqueue_scripts' ] );
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

    public function ffr_enqueue_scripts() {
        // wp_enqueue_style( 'fluent-features-board' );
        wp_enqueue_style( 'fluent-features-requests' );
        wp_enqueue_script( 'fluent-features-requests' );
    }

    /**
     * Render our admin page
     * @return void
     */
    public function ffb_menu_page_template() {
        echo '<div class="wrap"><div id="fluent-features-board-app"></div></div>';
    }


    public function features_request_lists() {
        echo '<div class="wrap"><div id="fluent-features-requests-app"></div></div>';
    }
}
