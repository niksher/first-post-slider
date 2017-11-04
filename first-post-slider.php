<?php

/*
Plugin Name: First post slider
Description: Change first post to slider
Version: 1.0
*/

/*  Copyright 2017  niksher  (email: niksher18@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

register_activation_hook(__FILE__, 'firstpostslider_install');
register_deactivation_hook(__FILE__, 'firstpostslider_uninstall');

function firstpostslider_install(){
    global $wpdb;
    $table_name = $wpdb->prefix . "first_post_slider_plugin";
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE " . $table_name . " (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            postId int NOT NULL,
            UNIQUE KEY id (id)
            );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    add_option("firstpostslider_status", "0");
}
function firstpostslider_uninstall() {
    global $wpdb;
    $table_name = $wpdb->prefix . "first_post_slider_plugin";

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }
    delete_option("firstpostslider_status");
}

add_action('admin_menu', 'firstpostslider_plugin_menu'); 

// 8 - права доступа не ниже администратора
function firstpostslider_plugin_menu() {
    $ADMIN_USER_ROLE = 8;
    add_options_page(
        'First Post Slider Plugin Options'
        , 'First Post Slider Plugin'
        , $ADMIN_USER_ROLE
        , __FILE__
        , 'firstpostslider_options'
    );
}

function firstpostslider_options() {
    global $wpdb;
    
    if (!current_user_can('8')) {
        wp_die( __('У вас нет прав доступа на эту страницу.') );
    }
    
    
    wp_register_style( 'style.css', plugin_dir_url( __FILE__ ) . 'assets/style.css', array());
    wp_enqueue_style( 'style.css');
    
    wp_register_script( 'script.js', plugin_dir_url( __FILE__ ) . 'assets/script.js', array());
    wp_register_script( 'jquery.min.js', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', array());
    
    wp_enqueue_script( 'jquery.min.js' );
    wp_enqueue_script( 'script.js' );
    
    if ($_GET["status"] == "active") {
        $active = $_POST["active"];
        
        echo update_option("firstpostslider_status", $active ? "1" : "0");
    }
    if ($_GET["status"] == "add") {
        $post_id = (int)$_POST["post_id"];
        $table_name = $wpdb->prefix . "first_post_slider_plugin";
        $oldpost = $wpdb->get_row("SELECT * FROM $table_name WHERE postId = $post_id");
        if (!$oldpost->postId) {
          $wpdb->insert($table_name, [
            "postId" => $post_id
          ]);
        }
    }
    if ($_GET["status"] == "del") {
        $post_id = (int)$_POST["post_id"];
        $table_name = $wpdb->prefix . "first_post_slider_plugin";
        $oldpost = $wpdb->get_row("SELECT * FROM $table_name WHERE postId = $post_id");
        if ($oldpost->postId) {
          $wpdb->delete($table_name, [
            "postId" => $post_id
          ]);
        }
    }

    if (!$_GET["status"]) {
        
        $table_name = $wpdb->prefix . "first_post_slider_plugin";
        $plugin_posts_temp = $wpdb->get_results("SELECT * FROM $table_name");
        $pliginIds = [];
        foreach ($plugin_posts_temp as $pp) {
            $pliginIds[] = $pp->postId;
        }
        
        $pliginArgs = [
            'post__in' => $pliginIds
            , 'posts_per_page' => 10
        ];
        
        if (count($pliginIds) > 0) {
            $plugin_posts = new WP_Query( $pliginArgs );
        }
        
        
        wp_reset_query();
        $page = $_GET["paged"] ? $_GET["paged"] : 1;
        $offset = ( $page - 1 ) * 10;

        $args  = [
            'posts_per_page' => 10
            , "paged" => $offset
        ];
        $posts = new WP_Query( $args );
        
        $postPaginator = fps_paginator($posts);
        $active_plugin = get_option("firstpostslider_status");
        
        include __DIR__ . '/view/list.php';
    }
}

function fps_paginator($custom_query) {
    global $wp_query;
    
    if (!$custom_query) {
        $custom_query = $wp_query;
    }
    
	$big = 999999999; // need an unlikely integer
	$pagination = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, $_GET["paged"] ),
		'total' => $custom_query->max_num_pages,
		'type'			=> 'plain',
		'before_page_number'	=>	'<span>',
		'after_page_number'	=>	'</span>',
		'prev_text'    => '<span>' . __('Previous','wi') . '</span>',
		'next_text'    => '<span>' . __('Next','wi') . '</span>',
	) );
	
	if ( $pagination ) {
        return ''
        . '<div class="wi-pagination"><div class="pagination-inner">'	
		. $pagination
		. '<div class="clearfix"></div></div></div>';
	}
}


add_action('template_redirect', 'are_we_home_yet', 10);

function are_we_home_yet(){
    global $template;
    $template_file = basename((__FILE__).$template);
    if ( is_home() && $template_file = 'home.php' ) {
      require_once plugin_dir_path(__FILE__) . '/includes/main.php';
      wp_register_style( 'homepagestyle.css', plugin_dir_url( __FILE__ ) . 'assets/homepagestyle.css', array());
      wp_enqueue_style( 'homepagestyle.css');
    }
}