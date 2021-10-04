<?php

namespace FFB;

/**
 * Shortcodes Handler
 */
class Shortcodes {

    public function __construct() {
        
        add_shortcode( 'fluent_features_board', [$this, 'ffb_shortcode'] );
        
    }

	public function ffb_shortcode( $atts = []) {
        global $wpdb;
        $atts = array_change_key_case((array) $atts, CASE_LOWER);
        $ffb_atts = shortcode_atts( 
            array(
                'id'    => ''
            ), $atts
        );
    
        if(!empty($ffb_atts['id'])) {
            $form = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."fluent_features_board WHERE id=".$ffb_atts['id']);
            ?>
            <div class="ffb-shortcode-output">
                <div class="ffb-shortcode-output-inner">
                    <?php 
                    foreach($form as $item) { ?>
                        <h1><?php echo esc_html( $item->title ); ?></h1>
                        <span class="tags"><?php //echo esc_html($item->tags); ?></span>
                        <p>
                            <?php //echo esc_html($item->description); ?>
                        </p>
                    <?php } ?>
                </div>
            </div>
            <?php
        } else {
            return;
        }

    }

}

