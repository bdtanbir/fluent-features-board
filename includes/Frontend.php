<?php

namespace FFB;

/**
 * Frontend Handler
 */
class Frontend {

    public function __construct()
    {
        add_shortcode( 'fluent_features_requests', [$this, 'render_frontend'] );
    }

    public function render_frontend($content) {
        wp_enqueue_style( 'fluent-features-board-frontend' );
        wp_enqueue_script( 'fluent-features-board-frontend');
        $content .= '<div id="fluent-features-board-frontend-app"></div>';
        return $content;
    }

}




