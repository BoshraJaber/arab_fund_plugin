<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function arab_funds_register_post_types() {
	
	// Create Custom Post Type For Country
	$labels = array(
				    'name'				=> __('Countrys', 'arabfunds'),
				    'singular_name' 	=> __('Country', 'arabfunds'),
				    'add_new' 			=> __('Add New', 'arabfunds'),
				    'add_new_item' 		=> __('Add New Country', 'arabfunds'),
				    'edit_item' 		=> __('Edit Country', 'arabfunds'),
				    'new_item' 			=> __('New Country', 'arabfunds'),
				    'all_items' 		=> __('Countrys', 'arabfunds'),
				    'view_item' 		=> __('View Country', 'arabfunds'),
				    'search_items' 		=> __('Search Country', 'arabfunds'),
				    'not_found' 		=> __('No Countrys found', 'arabfunds'),
				    'not_found_in_trash'=> __('No Countrys found in Trash', 'arabfunds'),
				    'parent_item_colon' => '',
				    'menu_name' => __('Countrys', 'arabfunds'),
				);
	
	$args = array(
			    'labels'				=> $labels,
			    'public'				=> true,
			    'publicly_queryable'	=> true,
			    'show_ui'				=> true, 
			    'show_in_menu'			=> true, 
			    'query_var'				=> true,
			    'rewrite'				=> array( 'slug' => ARAB_FUNDS_POST_TYPE_COUNTRY ),
			    'capability_type'		=> 'post',
			    'map_meta_cap'			=> true,
			    'has_archive'			=> true, 
			    'hierarchical'			=> false,
			    'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )				    
		  );
	
	register_post_type( ARAB_FUNDS_POST_TYPE_COUNTRY, $args );
}
//add_action( 'init', 'arab_funds_register_post_types' );