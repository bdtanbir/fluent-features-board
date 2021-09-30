<?php
namespace FFB;

/**
 * Scripts and Styles Class
 */
class FFB_Assets {

    function __construct() {
        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', [ $this, 'register' ], 5 );
        } else {
            add_action( 'wp_enqueue_scripts', [ $this, 'register' ], 5 );
        }
    }

    /**
     * Register our app scripts and styles
     * @return void
     */
    public function register() {
        $this->register_scripts( $this->get_scripts() );
        $this->register_styles( $this->get_styles() );
    }

    /**
     * Register scripts
     * @param  array $scripts
     * @return void
     */
    private function register_scripts( $scripts ) {
        foreach ( $scripts as $handle => $script ) {
            $deps      = isset( $script['deps'] ) ? $script['deps'] : false;
            $in_footer = isset( $script['in_footer'] ) ? $script['in_footer'] : false;
            $version   = isset( $script['version'] ) ? $script['version'] : FFB_VERSION;

            wp_register_script( $handle, $script['src'], $deps, $version, $in_footer );
        }
    }

    /**
     * Register styles
     * @param  array $styles
     * @return void
     */
    public function register_styles( $styles ) {
        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, FFB_VERSION );
        }
    }

    /**
     * Get all registered scripts
     * @return array
     */
    public function get_scripts() {
        // $prefix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.min' : '';

        $scripts = [
            'fluent-features-board-runtime' => [
                'src'       => FFB_ASSETS . '/js/runtime.js',
                'version'   => filemtime( FFB_PATH . '/assets/js/runtime.js' ),
                'in_footer' => true
            ],
            'fluent-features-board-vendor' => [
                'src'       => FFB_ASSETS . '/js/vendors.js',
                'version'   => filemtime( FFB_PATH . '/assets/js/vendors.js' ),
                'in_footer' => true
            ],
            'fluent-features-board-frontend' => [
                'src'       => FFB_ASSETS . '/js/frontend.js',
                'deps'      => [ 'jquery', 'fluent-features-board-vendor', 'fluent-features-board-runtime' ],
                'version'   => filemtime( FFB_PATH . '/assets/js/frontend.js' ),
                'in_footer' => true
            ],
            'fluent-features-board' => [
                'src'       => FFB_ASSETS . '/js/admin.js',
                'deps'      => [ 'jquery', 'fluent-features-board-vendor', 'fluent-features-board-runtime' ],
                'version'   => filemtime( FFB_PATH . '/assets/js/admin.js' ),
                'in_footer' => true
            ],
            'fluent-features-requests' => [
                'src'       => FFB_ASSETS . '/js/ffr_admin.js',
                'deps'      => [ 'jquery', 'fluent-features-board-vendor', 'fluent-features-board-runtime' ],
                'version'   => filemtime( FFB_PATH . '/assets/js/ffr_admin.js' ),
                'in_footer' => true
            ]
        ];

        return $scripts;
    }

    /**
     * Get registered styles
     * @return array
     */
    public function get_styles() {

        $styles = [
            'fluent-features-board' => [
                'src' =>  FFB_ASSETS . '/css/admin.css'
            ],
            'fluent-features-request' => [
                'src' =>  FFB_ASSETS . '/css/ffr_admin.css'
            ],
            'fluent-features-board-frontend' => [
                'src' =>  FFB_ASSETS . '/css/frontend.css'
            ],
        ];

        return $styles;
    }

}
