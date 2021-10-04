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
            $current_feature_board = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."fluent_features_board WHERE id=".$ffb_atts['id']);

            $form = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."ff_requests_list WHERE parent_id=".$ffb_atts['id']);
            foreach($current_feature_board as $board) {
                $col = '<div class="ff-requests-list-home">';

                $col .= '<header>';
                $col .= '<div class="ffr-wrap">';
                $col .= '<div class="header-left">';
                $col .= '<img src="'.$board->logo.'" alt="">';
                $col .= '<div class="header-left-content">';
                $col .= '<h3><a href="">'.$board->title.'</a></h3>';
                $col .= '<div class="links">';
                $col .= '<a href="https://adreastrian.com/">AuthLab Homepage</a>';
                $col .= '</div>';
                $col .= '</div>';
                $col .= '</div>';
                $col .= '<div class="header-right">';

                $col .= '<ul>';
                if(!is_user_logged_in(  )) {
                    $col .= '<li><a class="user-login user-in" href="#">Login</a></li>';
                } else {
                    $col .= '<li class="user-logout user-out">';
                    $col .= '<a href="#">';
                    $col .= 'Hi, '.get_the_author().' <span class="downicon"></span>';
                    $col .= '</a>';
                    $col .= '<div class="user-logout-dropdown">';
                    $col .= '<a class="user-logout" href="'.wp_logout_url( home_url() ).'">';
                    $col .= '<span class="logout-power-icon"></span> Logout';
                    $col .= '</a>';
                    $col .= '</div>';
                    $col .= '</li>';
                }
                $col .= '</ul>';

                $col .= '</div>';
                $col .= '</div>';
                $col .= '</header>';
                
                $col .= '<div class="ff-request-list-inner">';
                $col .= '<div class="ff-requests-wrapper">';
                $col .= '<div class="ffr-wrap">';

                $col .= '<div class="ff-requests-header">';
                $col .= '<div class="d-flex">';
                $col .= '<button class="ff-addnewrequest">';
                $col .= 'New Feature Request';
                $col .= '</button>';
                $col .= '<div class="ff-requests-search">';
                $col .= '<input id="search-request" type="text" name="search" placeholder="Search feature requests">';
                $col .= '</div>';
                $col .= '</div>';

                $col .= '<div class="ff-requests-form-wrap">';
                $col .= '<form class="ff-requests-form" id="ff-request-frontend-form">';
                $col .= '<h1>Suggest new feature</h1>';
                $col .= '<div class="input-group">';
                $col .= '<input id="search-request" type="text" name="title" placeholder="Title">';
                $col .= '</div>';
                $col .= '<div class="input-group">';
                $col .= '<textarea name="description" id="description" placeholder="Why do you want this"></textarea>';
                $col .= '</div>';
                $col .= '<div class="input-group">';
                $col .= '<button class="ff-request-submit">';
                $col .= 'Suggest Feature';
                $col .= '</button>';
                $col .= '</div>';
                $col .= '</form>';
                $col .= '</div>';
                $col .= '</div>';

                $col .= '<div class="ff-requests-list-box">';
                $col .= '<p>('.count($form).') feature requests</p> ';
                $col .= '<div class="ff-requests-list-body">';

                foreach($form as $item) {
                    // $t_slug = strtolower(str_replace(' ', '-', $item->title));
                    $col .= '<div class="ff-request-item" data-name="'.$item->title.'">';
                    $col .= '<div class="ff-request-vote">';
                    $col .= '<span class="ff-request-vote-btn"></span>';
                    $col .= '<span class="ff-request-vote-count">10</span>';
                    $col .= '</div>';
                    $col .= '<div class="ff-request-content">';
                    $col .= '<h3>';
                    $col .= '<a href="">';
                    $col .= $item->title;
                    $col .= '</a>';
                    $col .= '</h3>';
                    $col .= '<p>'.$item->description.'</p>';
                    $col .= '</div>';
                    $col .= '<a href="" class="ff-request-comment-count">';
                    $col .= '<span class="comment-icon"></span>';
                    $col .= '<span class="comment-number">10</span>';
                    $col .= '</a>';
                    $col .= '</div>';
                }

                $col .= '</div>';
                $col .= '</div>';
                            
                $col .= '</div>';
                $col .= '</div>';
                $col .= '</div>';
                $col .= '</div>';
            }
            return $col;
        }

    }

}

