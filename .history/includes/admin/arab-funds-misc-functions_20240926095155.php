<?php

/**
 *  Function for display translated string
*/
function arabfund_plugin_str_display($string){
    if ( function_exists( 'pll__' ) ) {
        return pll__($string);
    }
    return $string; 
}

/* Custom method to fetch available years for projects listing filter */
function arab_funds_get_available_years(){

    return array(
        '2022','2021','2020','2019','2018','2017','2016','2015','2014','2013','2012','2011','2010',
        '2009','2008','2007','2006','2005','2004','2003','2002','2001','2000','1999','1998','1997',
        '1996','1995','1994','1993','1994','1993','1992','1991','1990','1989','1988','1987','1986',
        '1985','1984','1983','1982','1981','1980','1979','1978','1977','1976','1975','1974',
    );

}

/* Custom method to fetch projects based on country and projects */
function arab_funds_get_all_sectors() {

    $current_language = pll_current_language();
    $country_sector_data = array();
    $args = array(
        'lang'      => $current_language,
        'post_type' => 'sectors',           // Your custom post type name
        'post_status' => 'publish',          // Post status
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    );

    $country_sector_data = get_posts($args);
    return $country_sector_data;
}

/* Custom method to fetch countries based on current pll language */
function arab_funds_get_countries( $lang = '' ) {
    $country_data = array();
    $args = array(
        'post_type' => 'countries',           // Your custom post type name
        'post_status' => 'publish',          // Post status
        'numberposts' => -1,
        'lang' => $lang,
        'orderby' => 'title',
        'order' => 'ASC'
    );
    $country_data = get_posts($args);
    return $country_data;
}

/* Custom method to fetch projects based on country and projects */
// function arab_funds_get_projects_by_country_sector( $country_id = '' , $sector_name = '' , $project_type = array()) {

//     $sector_details = get_page_by_title($sector_name, OBJECT, 'sectors');
//     $sector_id = $sector_details->ID;
//     $country_sector_data = array();
//     $current_language = pll_current_language();
//     $args = array(
//         'post_type' => 'projects',           // Your custom post type name
//         'post_status' => 'publish',          // Post status
//         'numberposts' => -1,
//         'ar' => $current_language, 
//         'meta_query' => array(
//             'relation' => 'AND',
//             array(
//                 'key' => 'project_sector',       // Meta key for project_type
//                 'value' =>  $sector_id,             // Meta value to match
//                 'compare' => '=',               // Comparison operator (optional, default is '=')
//             ),
//             array(
//                 'key' => 'project_country',    // Meta key for project_country
//                 'value' =>  $country_id, // Replace 'your_country_value' with the actual value to match
//                 'compare' => '=',               // Comparison operator (optional, default is '=')
//             ),
//             array(
//                 'key' => 'project_type',    // Meta key for project_country
//                 'value' => $project_type, // Replace 'your_country_value' with the actual value to match
//                 'compare' => 'IN',               // Comparison operator (optional, default is '=')
//             )

//             // Add more meta queries as needed
//         ),
//     );

//    $projects_data = get_posts($args);
//    $project_original_amount = 0.0;
//    $project_cancelled_amount = 0.0;
//    $project_net_amount = 0.0; 
   
//    /*if( $sector_name == 'Industry and Mining'  ) {
//         ini_set('display_errors', 1);
//         ini_set('display_startup_errors', 1);
//         error_reporting(E_ALL);
//    }*/

//    if( !empty(  $projects_data ) && is_array( $projects_data ) ) {

//         foreach( $projects_data as $key => $projects ) {

//             $original_amount  =  floatval(get_field('project_original_amount',$projects->ID));
//             $cancelled_amount =  floatval(get_field('project_cancelled_amount',$projects->ID));
//             $net_amount       =  floatval(get_field('project_net_amount',$projects->ID));

//             $project_original_amount += $original_amount;
//             $project_cancelled_amount += $cancelled_amount;
//             $project_net_amount += $net_amount;

//         }
//    }

//    $project_original_amount = ( $project_original_amount / 1000 );  
//    $project_cancelled_amount = ( $project_cancelled_amount / 1000 );
//    $project_net_amount = ( $project_net_amount / 1000 );

//    $project_original_amount = number_format($project_original_amount, 2, '.', ',');
//    $project_original_amount = rtrim($project_original_amount, '0');
//    $project_original_amount = rtrim($project_original_amount, '.');

//    $project_cancelled_amount = number_format($project_cancelled_amount, 2, '.', ',');
//    $project_cancelled_amount = rtrim($project_cancelled_amount, '0');
//    $project_cancelled_amount = rtrim($project_cancelled_amount, '.');

//    $project_net_amount = number_format($project_net_amount, 2, '.', ',');
//    $project_net_amount = rtrim($project_net_amount, '0');
//    $project_net_amount = rtrim($project_net_amount, '.');

//    $country_sector_data['total_original_amount'] = $project_original_amount;
//    $country_sector_data['total_cancelled_amount'] = $project_cancelled_amount;
//    $country_sector_data['total_net_amount'] = $project_net_amount;
//    $country_sector_data['available_projects'] = $projects_data;  
//    $country_sector_data['assigned_sector'] = $sector_name;

//    return $country_sector_data; 

// }
function arab_funds_get_projects_by_country_sector($country_id = '', $sector_name = '', $project_type = array())
{

    // Use WP_Query to get the sector by title
    $args_sector = array(
        'post_type' => 'sectors',
        'title' => $sector_name,
        'post_status' => 'publish',
        'posts_per_page' => 1,
    );

    $sector_query = new WP_Query($args_sector);
    $sector_id = '';

    // Check if the sector is found
    if ($sector_query->have_posts()) {
        while ($sector_query->have_posts()) {
            $sector_query->the_post();
            $sector_id = get_the_ID();  // Get the ID of the sector
        }
        wp_reset_postdata();
    } else {
        error_log("Sector not found: " . $sector_name);
        return array();  // Return an empty array if sector is not found
    }

    if (empty($sector_id)) {
        error_log("No sector ID found");
        return array(); // If sector ID is not found, return early
    }

    // Prepare the arguments for the projects query
    $current_language = pll_current_language();
    $args = array(
        'post_type' => 'projects',           // Your custom post type name
        'post_status' => 'publish',          // Post status
        'numberposts' => -1,
        'ar' => $current_language,           // Current language
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'project_sector',   // Meta key for project_type
                'value' => $sector_id,      // Meta value to match
                'compare' => '=',            // Comparison operator
            ),
            array(
                'key' => 'project_country',  // Meta key for project_country
                'value' => $country_id,     // Meta value to match
                'compare' => '=',            // Comparison operator
            ),
            array(
                'key' => 'project_type',     // Meta key for project_type
                'value' => $project_type,    // Array of project types
                'compare' => 'IN',           // Comparison operator
            ),
        ),
    );

    // Get the project posts
    $projects_data = get_posts($args);

    $project_original_amount = 0.0;
    $project_cancelled_amount = 0.0;
    $project_net_amount = 0.0;

    if (!empty($projects_data) && is_array($projects_data)) {
        foreach ($projects_data as $projects) {
            $original_amount = floatval(get_field('project_original_amount', $projects->ID));
            $cancelled_amount = floatval(get_field('project_cancelled_amount', $projects->ID));
            $net_amount = floatval(get_field('project_net_amount', $projects->ID));

            $project_original_amount += $original_amount;
            $project_cancelled_amount += $cancelled_amount;
            $project_net_amount += $net_amount;
        }
    } else {
        error_log("No projects found for country: $country_id and sector: $sector_name");
    }

    // Format amounts
    $project_original_amount = number_format($project_original_amount / 1000, 2, '.', ',');
    $project_cancelled_amount = number_format($project_cancelled_amount / 1000, 2, '.', ',');
    $project_net_amount = number_format($project_net_amount / 1000, 2, '.', ',');

    // Remove trailing zeroes and dots
    $project_original_amount = rtrim(rtrim($project_original_amount, '0'), '.');
    $project_cancelled_amount = rtrim(rtrim($project_cancelled_amount, '0'), '.');
    $project_net_amount = rtrim(rtrim($project_net_amount, '0'), '.');

    // Populate the return data
    $country_sector_data['total_original_amount'] = $project_original_amount;
    $country_sector_data['total_cancelled_amount'] = $project_cancelled_amount;
    $country_sector_data['total_net_amount'] = $project_net_amount;
    $country_sector_data['available_projects'] = $projects_data;
    $country_sector_data['assigned_sector'] = $sector_name;

    return $country_sector_data;
}


function arab_funds_get_trainings_by_section( $current_lang , $section_id , $training_id ) {

    $section_id_formatted = ':"' . preg_quote($section_id, ':') . '";';
    $args = array(
        'lang'        => $current_lang,    
        //'numberposts' => -1, 
        'posts_per_page' => -1,  
        'post_type' => 'topics',           // Your custom post type name
        'post_status' => 'publish',          // Post status
        // 'meta_query' =>  array(
        //     'key' => 'choose_training_component_2',
        //     'value' => $section_id_formatted,
        //     'compare' => 'REGEXP',
        // )
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'choose_training_program',       // Meta key for project_type
                'value' =>  $training_id,             // Meta value to match
                'compare' => '=',               // Comparison operator (optional, default is '=')
            ),
            array(
                'key' => 'choose_training_component_2', // name of custom field
                'value' => $section_id, // matches exactly "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )
        
    );

    $training_query = new WP_Query( $args ); 
    wp_reset_query();   
    return $training_query->posts;

}

function arab_funds_contribution_to_capital_data( $type , $country_id ) {
    
    $current_language = pll_current_language();
    $arab_contri_cap_data = array();
    $main_meta_query = array(
        'relation' => 'AND',
        'lang' => $current_language,
        array(
            'key' => 'project_type',       // Meta key for project_type
            'value' => $type,             // Meta value to match
            'compare' => '=',               // Comparison operator (optional, default is '=')
        ),
        array(
            'key' => 'project_is_contribution_capital',    // Meta key for project_country
            'value' => 1, // Replace 'your_country_value' with the actual value to match
            'compare' => '=',               // Comparison operator (optional, default is '=')
        )
        // Add more meta queries as needed    
    );

    if($country_id != 0 &&  $type == 'private' ) {
        $main_meta_query[] = array(
            'key' => 'project_country',
            'value' => $country_id,
            'compare' => '=',
        );
    }     

    $args = array(
        'lang'        => $current_language,    
        'numberposts' => -1,    
        'post_type' => 'projects',           // Your custom post type name
        'post_status' => 'publish',          // Post status
        'meta_query' =>  $main_meta_query,
    );
    $total_amount = 0;
    $projects_query = get_posts($args);
    $arab_contri_cap_data['projects_count'] = 0;
    if( !empty( $projects_query && is_array( $projects_query ) ) ) {
        $arab_contri_cap_data['projects_count'] = count($projects_query);
        foreach( $projects_query as $key => $projects_data ) {
            $project_amount = get_post_meta($projects_data->ID, 'project_amount_paid', true); 
            $total_amount += floatval($project_amount);
               
        }
    }

    //$total_sum = ( $total_amount / 1000 );
    $arab_contri_cap_data['projects_contri_amount'] = $total_amount; 
    return $arab_contri_cap_data;

}

/* Custom method to fetch total counts and sum of amount for all the grants */
function arab_funds_total_count_loan_sum( $type = '' ) {

    $current_language = pll_current_language();
	$arab_funds_data = array();
    $main_meta_query = array(
        array(
            'key' => 'project_type',       // Meta key for project_type
            'value' => $type,             // Meta value to match
            'compare' => '=',               // Comparison operator (optional, default is '=')
        ),
        // Add more meta queries as needed
    );

    if( $type == 'private' ) {
        $main_meta_query[] = array(
            'key' => 'project_is_contribution_capital',
            'value' => 0,
            'compare' => '=',
        );
    }

	$args = array( 
    'posts_per_page' => -1,
    'lang' => $current_language,           
    'post_type' => 'projects',           // Your custom post type name
    'post_status' => 'publish',          // Post status
    'meta_query' => $main_meta_query,
   );


   $projects_query = new WP_Query($args);
   if( $type == 'private' ) {
    $arab_contri_cap_data = arab_funds_contribution_to_capital_data( $type , 0 );
    $project_count = ($projects_query->found_posts + $arab_contri_cap_data['projects_count']);
   } else {
    $project_count = $projects_query->found_posts;
   }
   $total_amount = 0;
   $total_cancelled = 0;

   // The Loop
	if ($projects_query->have_posts()) {
	    while ($projects_query->have_posts()) {
	        $projects_query->the_post();
                // Get the value of the 'project_type' meta key
                if( $type == 'private' ) { 
                    $total_cancelled += get_post_meta(get_the_ID(), 'project_cancelled_amount', true);
                }    
                $project_amount = get_post_meta(get_the_ID(), 'project_original_amount', true);
                $total_amount += $project_amount;
           
	    }
	    /* Restore original Post Data */
	    wp_reset_postdata();
	} 

   $total_sum = ( $total_amount / 1000 );
   $arab_funds_data['projects_count'] = $project_count;
   /*if( $type == 'private' ) {
    
        $arab_total_contributions = ( $arab_contri_cap_data['projects_contri_amount'] / 100 );    
        $arab_funds_data['projects_amount'] = floatval( $total_sum + $arab_total_contributions );    
   } else {
        $arab_funds_data['projects_amount'] = $total_sum;
   }*/    
   if( $type == 'private' ) {   
       $arab_total_contributions = ( $arab_contri_cap_data['projects_contri_amount'] / 1000 );
       $total_cancelled = ( $total_cancelled / 1000 );        
       $total_sum = ( $total_sum - $total_cancelled ) + $arab_total_contributions;
       //echo $total_sum;
   }
   $arab_funds_data['projects_amount'] = $total_sum;
   return $arab_funds_data;
}

/* Custom method to fetch total countries for displaying on front-end */
function arab_funds_total_countries_display(){
 
	$args = array(
        'post_type'     => 'countries',           // Your custom post type name
        'post_status'   => 'publish',   
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',     
   );

   $country_query = new WP_Query($args);
   return $country_query;

}

/* Custom method to fetch projects based on filter criteria years, sectors, country */
function  arab_funds_projects_based_filters (  $lang = '' , $project_type = '' ,  $filter_key = '' , $filter_value = '' , $filter_country = '' , $filter_sector = '' , $filter_year = '' ) {

    if( $project_type != 'contribution' ) {
        $default_project_type = $project_type;
    } else {
        $default_project_type = "private";
    }
   
    $main_meta_query = array(
        'relation' => 'AND',
        'lang'     => $lang, 
        'post_status' => 'publish',
        'order' => 'DESC',
        array(
            'key' => 'project_type',       // Meta key for project_type
            'value' => $default_project_type,             // Meta value to match
            'compare' => '=',               // Comparison operator (optional, default is '=')
        ),
        /*array(
            'key' => $filter_key,    // Meta key for project_country
            'value' => $filter_value, // Replace 'your_country_value' with the actual value to match
            'compare' => '=',               // Comparison operator (optional, default is '=')
        )*/
        // Add more meta queries as needed
    );

    /*echo "<pre>";
        print_r($main_meta_query);
    echo "</pre>";
    wp_die("Aaaa");*/
    
    if(!empty($filter_country)){
         $main_meta_query[] =  array(
             'key' => 'project_country',    // Meta key for project_country
             'value' => $filter_country, // Replace 'your_country_value' with the actual value to match
             'compare' => '='               // Comparison operator (optional, default is '=')
         );
     }
     if(!empty($filter_year)){
         $main_meta_query[] =  array(
             'key' => 'project_approved_year',    // Meta key for project_country
             'value' => $filter_year, // Replace 'your_country_value' with the actual value to match
             'compare' => '='               // Comparison operator (optional, default is '=')
         );
     }
     if(!empty($filter_sector)){
        $main_meta_query[] =  array(
            'key' => 'project_sector',    // Meta key for project_country
            'value' => $filter_sector, // Replace 'your_country_value' with the actual value to match
            'compare' => '='               // Comparison operator (optional, default is '=')
        );
    }

    if( $project_type == 'contribution' ) {
        $main_meta_query[] = array(
            'key' => 'project_is_contribution_capital',
            'value' => 1,
            'compare' => '=',
        );
    } else if ( $project_type == 'private' ) {
        $main_meta_query[] = array(
            'key' => 'project_is_contribution_capital',
            'value' => 0,
            'compare' => '=',
        );
    }

    

    $arab_funds_data = array();
        $args = array(
        'lang'        => $lang,    
        'numberposts' => -1,    
        'post_type' => 'projects',           // Your custom post type name
        'post_status' => 'publish',          // Post status
        'meta_query' => $main_meta_query,
        'orderby' => 'meta_value_num',       // Order by numeric value of meta field
    'meta_key' => 'project_loan_number',     // Meta key to order by
    'order' => 'DESC',                   // Descending order
    );

    /*echo "<pre>";
    print_r($args);
   echo "</pre>";
  wp_die("Aaaa");*/   

   $projects_query = get_posts($args);
   $project_original_amount = 0.0;
   $project_cancelled_amount = 0.0;
   $project_net_amount = 0.0; 
   $project_amount_paid = 0.0;

   

   // The Loop
	if ( !empty( $projects_query ) ) {
	    foreach( $projects_query as $key => $projects ) {
	    
                // Get the value of the 'project_type' meta key
                $original_amount  =  floatval(get_field('project_original_amount',$projects->ID));
                $cancelled_amount =  floatval(get_field('project_cancelled_amount',$projects->ID));
                $net_amount       =  floatval(get_field('project_net_amount',$projects->ID));
                $is_amount_paid      =  get_field('project_is_contribution_capital',$projects->ID);
                if( $is_amount_paid ) {
                    $total_amount_paid = floatval(get_field('project_amount_paid',$projects->ID));
                }
    
                $project_original_amount += $original_amount;
                $project_cancelled_amount += $cancelled_amount;
                $project_net_amount += $net_amount;
                $project_amount_paid += $total_amount_paid;
	    }
	} 

    $project_original_amount =  ( $project_original_amount / 1000 );  
    $project_cancelled_amount = ( $project_cancelled_amount / 1000 );
    $project_net_amount = ( $project_net_amount / 1000 );
    $project_amount_paid = ( $project_amount_paid / 1000 );
 
    $project_original_amount = number_format($project_original_amount, 2, '.', ',');
    $project_original_amount = rtrim($project_original_amount, '0');
    $project_original_amount = rtrim($project_original_amount, '.');
    
    $project_cancelled_amount = number_format($project_cancelled_amount, 2, '.', ',');
    $project_cancelled_amount = rtrim($project_cancelled_amount, '0');
    $project_cancelled_amount = rtrim($project_cancelled_amount, '.');
 
    $project_net_amount = number_format($project_net_amount, 2, '.', ',');
    $project_net_amount = rtrim($project_net_amount, '0');
    $project_net_amount = rtrim($project_net_amount, '.');

    $project_amount_paid = number_format($project_amount_paid, 2, '.', ',');
    $project_amount_paid = rtrim($project_amount_paid, '0');
    $project_amount_paid = rtrim($project_amount_paid, '.');

    $arab_funds_data['projects_count'] = count($projects_query);
    $arab_funds_data['projects_amount'] =  $project_original_amount;
    $arab_funds_data['projects_cancelled_amount'] = $project_cancelled_amount;
    $arab_funds_data['projects_net_amount'] =  $project_net_amount;
    $arab_funds_data['project_amount_paid'] =  $project_amount_paid;
    $arab_funds_data['projects_loan'] =  $projects_query;
   return $arab_funds_data;

}

/* Custom method to fetch total counts and amount based on Country and Project type*/
function arab_funds_display_data_country_project_type( $country_id = '' , $project_type = '' ){
 
        $current_language = pll_current_language();
        $arab_funds_data = array();
       
        if($country_id === ""){
            $main_meta_query = array(
                
                array(
                    'key' => 'project_type',       // Meta key for project_type
                    'value' => $project_type,             // Meta value to match
                    'compare' => '=',               // Comparison operator (optional, default is '=')
                ),
                // Add more meta queries as needed
            );
        }else{
            $main_meta_query = array(
                'relation' => 'AND',
                array(
                    'key' => 'project_type',       // Meta key for project_type
                    'value' => $project_type,             // Meta value to match
                    'compare' => '=',               // Comparison operator (optional, default is '=')
                ),
                array(
                    'key' => 'project_country',    // Meta key for project_country
                    'value' =>  $country_id, // Replace 'your_country_value' with the actual value to match
                    'compare' => '=',               // Comparison operator (optional, default is '=')
                )
                // Add more meta queries as needed
            );
        }
        if( $project_type == 'private' ) {
            $main_meta_query[] = array(
                'key' => 'project_is_contribution_capital',
                'value' => 0,
                'compare' => '=',
            );
        }

        $args = array(
        'numberposts' => -1,  
        //'paged'          => $_POST['paged'],  
        'post_type' => 'projects',           // Your custom post type name
        'post_status' => 'publish',          // Post status
        'lang'        => $current_language,    
        'meta_query' => $main_meta_query,
        'orderby' => 'meta_value_num',       // Order by numeric value of meta field
        'meta_key' => 'project_loan_number',     // Meta key to order by
        'order' => 'DESC',                   // Descending order
    );

   $projects_query = get_posts($args);
  
   $project_original_amount = 0.0;
   $project_cancelled_amount = 0.0;
   $project_net_amount = 0.0;
   $arab_contri_cap_data = arab_funds_contribution_to_capital_data( 'private' , $country_id );
   // The Loop
	if ( !empty( $projects_query ) ) {
	    foreach( $projects_query as $key => $projects ) {
	    
                // Get the value of the 'project_type' meta key
                $original_amount  =  floatval(get_field('project_original_amount',$projects->ID));
                $cancelled_amount =  floatval(get_field('project_cancelled_amount',$projects->ID));
                $net_amount       =  floatval(get_field('project_net_amount',$projects->ID));
    
                $project_original_amount += $original_amount;
                $project_cancelled_amount += $cancelled_amount;
                $project_net_amount += $net_amount;
	    }
	} 
    if( $project_type == 'private' ) {
        $total_private_amount = ( $arab_contri_cap_data['projects_contri_amount'] + $project_net_amount );
        $project_net_amount += $arab_contri_cap_data['projects_contri_amount']; 
    }

    $project_original_amount =  ( $project_original_amount / 1000 );  
    $project_cancelled_amount = ( $project_cancelled_amount / 1000 );
    $project_net_amount = ( $project_net_amount / 1000 );
   
 
    $project_original_amount = number_format(round($project_original_amount), 2, '.', ',');
    $project_original_amount = rtrim($project_original_amount, '0');
    $project_original_amount = rtrim($project_original_amount, '.');
    
    $project_cancelled_amount = number_format($project_cancelled_amount, 2, '.', ',');
    $project_cancelled_amount = rtrim($project_cancelled_amount, '0');
    $project_cancelled_amount = rtrim($project_cancelled_amount, '.');
 
    $project_net_amount = number_format($project_net_amount, 2, '.', ',');
    $project_net_amount = rtrim($project_net_amount, '0');
    $project_net_amount = rtrim($project_net_amount, '.');

    if( $project_type == 'private' ) {
        $arab_funds_data['projects_count'] = (count($projects_query) + $arab_contri_cap_data['projects_count'] );
    } else {
        $arab_funds_data['projects_count'] = count($projects_query);
    }    

    $arab_funds_data['projects_amount'] =  $project_original_amount;
    $arab_funds_data['projects_cancelled_amount'] = $project_cancelled_amount;
    $arab_funds_data['projects_net_amount'] =  $project_net_amount;
    $arab_funds_data['projects_loan'] =  $projects_query;
    return $arab_funds_data;
}

/* Custom method to fetch total counts and amount based on Country and Project type*/
function arab_funds_display_data_country_grant_type( $country_id = '' ){
 
    $arab_funds_data = array();
    $args = array(
    'posts_per_page' => -1, 
    'post_type' => 'projects',           // Your custom post type name
    'post_status' => 'publish',          // Post status
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'project_type',       // Meta key for project_type
            'value' => 'grant',             // Meta value to match
            'compare' => '=',               // Comparison operator (optional, default is '=')
        ),
        array(
            'key' => 'project_country',    // Meta key for project_country
            'value' =>  $country_id, // Replace 'your_country_value' with the actual value to match
            'compare' => '=',               // Comparison operator (optional, default is '=')
        )
        // Add more meta queries as needed
    ),
);

$projects_query = new WP_Query($args);
$project_count = $projects_query->found_posts;
$project_original_amount = 0.0;
$project_cancelled_amount = 0.0;
$project_net_amount = 0.0;

// The Loop
if ($projects_query->have_posts()) {
    while ($projects_query->have_posts()) {
        $projects_query->the_post();
        
           // Get the value of the 'project_type' meta key
           $original_amount  =  floatval(get_field('project_original_amount',get_the_ID()));
           $cancelled_amount =  floatval(get_field('project_cancelled_amount',get_the_ID()));
           $net_amount       =  floatval(get_field('project_net_amount',get_the_ID()));

           $project_original_amount += $original_amount;
           $project_cancelled_amount += $cancelled_amount;
           $project_net_amount += $net_amount;
        
    }
    /* Restore original Post Data */
    wp_reset_postdata();

} 

$project_original_amount = ( $project_original_amount / 1000 );  
$project_cancelled_amount = ( $project_cancelled_amount / 1000 );
$project_net_amount = ( $project_net_amount / 1000 );

$project_original_amount = number_format($project_original_amount, 2, '.', ',');
$project_original_amount = rtrim($project_original_amount, '0');
$project_original_amount = rtrim($project_original_amount, '.');

$project_cancelled_amount = number_format($project_cancelled_amount, 2, '.', ',');
$project_cancelled_amount = rtrim($project_cancelled_amount, '0');
$project_cancelled_amount = rtrim($project_cancelled_amount, '.');

$project_net_amount = number_format($project_net_amount, 2, '.', ',');
$project_net_amount = rtrim($project_net_amount, '0');
$project_net_amount = rtrim($project_net_amount, '.');

$arab_funds_data['projects_count'] = $project_count;
$arab_funds_data['projects_amount'] = $project_original_amount;
$arab_funds_data['projects_cancelled_amount'] = $project_cancelled_amount;
$arab_funds_data['projects_net_amount'] =  $project_net_amount;
$arab_funds_data['projects_loan'] =  $projects_query->posts;
return $arab_funds_data;

}

/* Custom functionality to load results after search  */
function arab_funds_show_country_search_results() {

    $start_with = sanitize_text_field($_POST['country_search']);    
    $lang = $_POST['lang'];
    $current_language = pll_current_language();
    $args = array("post_type" => "countries", 'post_status' => 'publish', 'orderby' => 'title','order' => 'ASC','lang' => $lang,'order' => 'ASC','orderby' => 'title');
    if( !empty( $start_with ) ) {
        $args["s"] = $start_with;
    } else {
        $args["numberposts"] = "8";
    }      
    $countries_query = get_posts( $args );
    ob_start();
    if( !empty(  $countries_query ) ) {
        foreach( $countries_query as $key => $projects ) {
            $country_image_url = get_the_post_thumbnail_url($projects->ID, 'full');
            $country_signed_loans_data = arab_funds_display_data_country_project_type($projects->ID,'loan');
            $country_grants_data = arab_funds_display_data_country_project_type($projects->ID,'grant');
            if ($current_language === 'en-us') {
                $country_loans_url   = get_site_url() . '/overview/list-of-all-projects?ptype=loan&cid=' . $projects->ID;
                $country_grants_url  = get_site_url() . '/overview/list-of-all-projects?ptype=grant&cid=' . $projects->ID;
            } else {
                $country_loans_url   = get_site_url() . '/' . $current_language . '/afesd-activities/list-of-all-projects?ptype=loan&cid=' . $projects->ID;
                $country_grants_url  = get_site_url() . '/' . $current_language . '/afesd-activities/list-of-all-projects?ptype=grant&cid=' . $projects->ID;
            }
           ?>
             <div class="country-card">
                <div class="country-flag">
                    <div class="flag-img">
                        <img src="<?php echo $country_image_url; ?>" alt="">
                    </div>
                    <p class="text-26"><?php echo $projects->post_title;?></p>
                </div>
                <div class="line"></div>
                <p class="country-flag-title text-21 text-center"><?php echo arabfund_plugin_str_display('SIGNED LOANS')?></p>
                <div class="line"></div>
                <div class="country-flag-info d-flex justify-content-around align-items-center">
                    <div class="anchor-green-underline">
                        <p class="text-21 text-gray al-jazeera-regular"><?php echo arabfund_plugin_str_display('NUMBER')?></p>
                        <a class="text-28 text-success " href="<?php echo $country_loans_url;?>"><?php echo $country_signed_loans_data['projects_count']; ?></a>
                    </div>
                    <div class="anchor-green-underline">
                        <p class="text-19 al-jazeera-regular"><?php echo arabfund_plugin_str_display('VALUES')?></p>
                        <p class="text-28 "><?php echo $country_signed_loans_data['projects_amount']; ?></p>
                        <p class="text-15 al-jazeera-regular"><?php echo arabfund_plugin_str_display('One thousand KD*')?></p>
                    </div>
                </div>
                <div class="line"></div>
                <p class="country-flag-title text-21 text-center"><?php echo arabfund_plugin_str_display('EXTENDED GRANTS')?></p>
                <div class="line"></div>
                <div class="country-flag-info d-flex justify-content-around align-items-center">
                    <div class="anchor-green-underline">
                        <p class="text-21 text-gray al-jazeera-regular"><?php echo arabfund_plugin_str_display('NUMBER')?></p>
                        <a class="text-28 text-success " href="<?php echo $country_grants_url;?>"><?php echo $country_grants_data['projects_count']; ?></a>
                    </div>
                    <div class="anchor-green-underline">
                    <p class="text-19 al-jazeera-regular"><?php echo arabfund_plugin_str_display('VALUES')?></p>
                        <p class="text-28 "><?php echo $country_grants_data['projects_amount']; ?></p>
                        <p class="text-15 al-jazeera-regular"><?php echo arabfund_plugin_str_display('One thousand KD*')?></p>
                    </div>
                </div>
                <div class="read-more d-flex align-items-center ">
                <?php if ($lang == 'ar'){?>
                    <a class="text-19 al-jazeera-regular link right-to-left" href="<?php echo get_the_permalink(); ?>"><?php echo arabfund_plugin_str_display("اقرأ أكثر"); ?></a>
                <?php }else {?>
                    <a class="text-19 al-jazeera-regular link right-to-left" href="<?php echo get_the_permalink(); ?>"><?php echo arabfund_plugin_str_display('Read More'); ?></a>
                <?php }?>
                <?php if ($lang == 'ar'){?>
                    <div class="icon-circle green-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20.243" height="13.501" viewBox="0 0 20.243 13.501">
                            <path id="Icon_ionic-ios-arrow-round-back" data-name="Icon ionic-ios-arrow-round-back" d="M15.216,11.51a.919.919,0,0,1,.007,1.294l-4.268,4.282H27.218a.914.914,0,0,1,0,1.828H10.955L15.23,23.2a.925.925,0,0,1-.007,1.294.91.91,0,0,1-1.287-.007L8.142,18.647h0a1.026,1.026,0,0,1-.19-.288.872.872,0,0,1-.07-.352.916.916,0,0,1,.26-.64l5.794-5.836A.9.9,0,0,1,15.216,11.51Z" transform="translate(-7.882 -11.252)" fill="#029b47" />
                        </svg>
                    </div>
                <?php } else {?>
                    <div class="icon-circle rotate-arrow green-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20.243" height="13.501" viewBox="0 0 20.243 13.501">
                            <path id="Icon_ionic-ios-arrow-round-back" data-name="Icon ionic-ios-arrow-round-back" d="M15.216,11.51a.919.919,0,0,1,.007,1.294l-4.268,4.282H27.218a.914.914,0,0,1,0,1.828H10.955L15.23,23.2a.925.925,0,0,1-.007,1.294.91.91,0,0,1-1.287-.007L8.142,18.647h0a1.026,1.026,0,0,1-.19-.288.872.872,0,0,1-.07-.352.916.916,0,0,1,.26-.64l5.794-5.836A.9.9,0,0,1,15.216,11.51Z" transform="translate(-7.882 -11.252)" fill="#029b47" />
                        </svg>
                    </div>
               <?php }?>
                </div>
            </div>   
           <?php
        }
    } else {
        ?>
            <p><?php echo esc_html('No country found according to search criteria.'); ?></p>
        <?php
    }

    $html = ob_get_clean();
    $count = count($countries_query);
    
    wp_reset_postdata();
    wp_send_json(array('html' => $html, 'count' => $count),200,JSON_UNESCAPED_UNICODE);

}
add_action('wp_ajax_nopriv_arab_country_search', 'arab_funds_show_country_search_results');
add_action('wp_ajax_arab_country_search', 'arab_funds_show_country_search_results');

/* Custom functionality to load map content on popup - on button click  */
function fetch_content_maps() {
    $post_id = $_POST['post_id'];
    $post_id = trim(str_replace('#', '', $post_id));
    $default_lang = $_POST['default_lang'];
    $args = array("post_type" => "countries", 'post_status' => 'publish','numberposts' => '1','s' => $post_id,'lang' => $default_lang);
    $countries_query = get_posts( $args );     
    if( !empty( $countries_query ) && is_array( $countries_query ) ) {  
        
        $country_title = $countries_query[0]->post_title;
        $country_image_url = get_the_post_thumbnail_url($countries_query[0]->ID, 'full');
                
        $country_signed_loans_data = arab_funds_display_data_country_project_type($countries_query[0]->ID,'loan');
        $country_grants_data = arab_funds_display_data_country_project_type($countries_query[0]->ID,'grant');
        
        // Check if the current language is English
        if ($default_lang === 'en-us') {
            $country_loans_url   = get_site_url() . '/overview/list-of-all-projects?ptype=loan&cid=' . $countries_query[0]->ID;
            $country_grants_url  = get_site_url() . '/overview/list-of-all-projects?ptype=grant&cid=' . $countries_query[0]->ID;
        } else {
            $country_loans_url   = get_site_url() . '/' . $default_lang . '/afesd-activities/list-of-all-projects?ptype=loan&cid=' . $countries_query[0]->ID;
            $country_grants_url  = get_site_url() . '/' . $default_lang . '/afesd-activities/list-of-all-projects?ptype=grant&cid=' . $countries_query[0]->ID;
        }     

    } 
    
   ?>
    <div class="country-card">
                <div class="country-flag">
                    <div class="flag-img">
                        <img src="<?php echo $country_image_url; ?>" alt="">
                    </div>
                    <p class="text-26"><?php echo $country_title;?></p>
                </div>
                <div class="line"></div>
                <p class="country-flag-title text-21 text-center"><?php echo arabfund_plugin_str_display('SIGNED LOANS')?></p>
                <div class="line"></div>
                <div class="country-flag-info d-flex justify-content-around align-items-center">
                    <div class="anchor-green-underline">
                        <p class="text-21 text-gray al-jazeera-regular"><?php echo arabfund_plugin_str_display('NUMBER')?></p>
                        <a class="text-28 text-success" href="<?php echo $country_loans_url; ?>"><?php echo $country_signed_loans_data['projects_count']; ?></a>
                    </div>
                    <div class="anchor-green-underline">
                        <p class="text-19 al-jazeera-regular"><?php echo arabfund_plugin_str_display('VALUES')?></p>
                        <p class="text-28 "><?php echo $country_signed_loans_data['projects_amount']; ?></p>
                        <p class="text-15 al-jazeera-regular"><?php echo arabfund_plugin_str_display('One thousand KD*')?></p>
                    </div>
                </div>
                <div class="line"></div>
                <p class="country-flag-title text-21 text-center"><?php echo arabfund_plugin_str_display('EXTENDED GRANTS')?></p>
                <div class="line"></div>
                <div class="country-flag-info d-flex justify-content-around align-items-center">
                    <div class="anchor-green-underline">
                        <p class="text-21 text-gray al-jazeera-regular"><?php echo arabfund_plugin_str_display('NUMBER')?></p>
                        <a class="text-28 text-success" href="<?php echo $country_grants_url; ?>"><?php echo $country_grants_data['projects_count']; ?></a>
                    </div>
                    <div class="anchor-green-underline">
                    <p class="text-19 al-jazeera-regular"><?php echo arabfund_plugin_str_display('VALUES')?></p>
                        <p class="text-28 "><?php echo $country_grants_data['projects_amount']; ?></p>
                        <p class="text-15 al-jazeera-regular"><?php echo arabfund_plugin_str_display('One thousand KD*')?></p>
                    </div>
                </div>
                <div class="popup_footer">
                    <a href="<?php echo get_the_permalink($countries_query[0]->ID); ?>" class="countries_btn countries_read_more"> <span class="en_view">Read More</span><span class="ar_view">اقرأ أكثر</span></a>
                    <a href="javascript:void(0);" class="countries_btn countries_close close-popup"><span class="en_view">Close</span><span class="ar_view">إغلاق</span></a>
                </div>
                
        </div>
  <?php
  die();    
}
add_action('wp_ajax_fetch_maps', 'fetch_content_maps');
add_action('wp_ajax_nopriv_fetch_maps', 'fetch_content_maps');

/* Custom functionality to load results after search  */
function arab_funds_show_projects_listing() {

    $current_language = $_POST['filter_data']['current_language'];  
    if ( !empty( $_POST['filter_data'] ) ) {

        $arab_filter_value = sanitize_text_field(trim($_POST['filter_data']['filter_value']));
        $arab_filter_type  = sanitize_text_field(trim($_POST['filter_data']['filter_type']));
        $arab_project_type = sanitize_text_field(trim($_POST['filter_data']['filter_selected_type']));
        $arab_filter_key   = "";
        $arab_heading_label = "";
        $arab_filter_secondary_label = "";
        $arab_project_type_title = "";
        $arab_filter_append_label = "";
        $arab_country_id = '';
        $arab_filter_country = !empty( $_POST['filter_data']['filter_country'] ) ? sanitize_text_field($_POST['filter_data']['filter_country']) : '';
        $arab_filter_sector  = !empty( $_POST['filter_data']['filter_sector'] ) ? sanitize_text_field($_POST['filter_data']['filter_sector']) : '';
        $arab_filter_year    = !empty( $_POST['filter_data']['filter_year'] ) ? sanitize_text_field($_POST['filter_data']['filter_year']) : '';
        if ( $arab_project_type == 'loan'  ) {
            $arab_filter_secondary_label = arabfund_plugin_str_display('Authorized Public Sector Loans');
            
        } else if ( $arab_project_type == 'grant'  ) {
            $arab_filter_secondary_label = arabfund_plugin_str_display('Extended Grants');
        } else if ( $arab_project_type == 'private'  ) {
            $arab_filter_secondary_label = arabfund_plugin_str_display('Authorized Private Sector Loans');
        } 
        // if ( empty($arab_filter_year) && empty($arab_filter_country) && !empty($arab_filter_sector)) {
        //     $arab_filter_append_label = 'during year '.$arab_filter_year.'';
        // }
        // if ( $arab_filter_year != ''  ) {
        //     $arab_filter_key  = "project_approved_year";
        //     $arab_heading_label =  arabfund_plugin_str_display('Year')." : ".$arab_filter_value;
        //     $arab_filter_secondary_label .= "خلال العام "." - ".$arab_filter_value;
        // } else if ( $arab_filter_sector == 'sector' ) {
        //     $arab_filter_key = "project_sector";
        //     $arab_sector_data = get_post( $arab_filter_value );
        //     $arab_heading_label =  arabfund_plugin_str_display('Sector')." : ".arabfund_plugin_str_display($arab_sector_data->post_title);
        //     $arab_filter_secondary_label .= "كما في 31/12/2022"." - ".arabfund_plugin_str_display($arab_sector_data->post_title);
        // } else if ( $arab_filter_country == 'country' ) {
        //     $arab_filter_key = "project_country";
        //     $arab_country_data = get_post( $arab_filter_value );
        //     $arab_heading_label =  arabfund_plugin_str_display('Country')." : ".$arab_country_data->post_title;
        //     $arab_filter_secondary_label .= " 31/12/2022 كما في"." - ".$arab_country_data->post_title;  
        //     $arab_country_id = $arab_country_data->ID;         
        // }

        //Checking if country id is empty by passing year and sector
        if( empty( $arab_country_id ) ) {
            $arab_country_id = trim($_POST['filter_data']['filter_default_country']);
        } 
        ob_start();
        
     
        $arab_available_projects = arab_funds_projects_based_filters (  $current_language , $arab_project_type ,  $arab_filter_key , $arab_filter_value , $arab_filter_country , $arab_filter_sector , $arab_filter_year ); 
        $country_label_heading .= " 31/12/2022 ".arabfund_plugin_str_display('as in')." - ".get_the_title($country_id);
        $arab_country_data = get_post( $arab_filter_country );
        if(!empty($arab_country_data->post_title)) {
            $arab_heading_label =  arabfund_plugin_str_display('Country')." : ".$arab_country_data->post_title;
        }
       
        //Extended Grants for Bahrain in the Social Services sector, as of 31/12/2022
        //Bahrain's Extended Grants during year 2016.
        // Authorized Grants in the Social Services sector during year 2016.
        // Bahrain's Extended Grants in the Social Services sector during the year 2016, as of 31/12/2022.
        if( !empty($arab_available_projects['projects_loan']) ) {
            ?>
             <div class="table-heading">
                 <div>
                    <?php if ( !empty($arab_filter_year) && empty($arab_filter_country) && empty($arab_filter_sector)) {
                        if($current_language === "ar"){?>
                       <!-- <span class="text-28"> اليمن - قروض القطاع العام المعتمدة  المقررة 2022/12/31 (المبالغ بالألف دينار كويتي)</span> -->
                       <span class="text-28"><?php echo $arab_filter_secondary_label . " خلال العام " . $arab_filter_year;?></span>
                        <?php }else{ ?>
                            <span class="text-28"><?php echo $arab_filter_secondary_label . " during year " . $arab_filter_year;?></span>
                       <?php }

                     }?>
                    <?php if ( empty($arab_filter_year) && empty($arab_filter_country) && !empty($arab_filter_sector)) {
                        $arab_sector_data = get_post( $arab_filter_sector );?>
                        <span class="text-28"><?php echo $arab_sector_data->post_title . " - " . $arab_filter_secondary_label;?> <?php echo $country_label_heading;?></span>
                    <?php }?>
                    <?php if ( empty($arab_filter_year) && !empty($arab_filter_country) && empty($arab_filter_sector)) {
                        
                        ?>
                        <span class="text-28"><?php echo $arab_filter_secondary_label;?>  <?php echo $country_label_heading . "" . $arab_country_data->post_title?></span>
                        
                        
                    <?php }?>
                    <?php if ( !empty($arab_filter_year) && !empty($arab_filter_country) && empty($arab_filter_sector)) {
                        
                        if($current_language === "ar"){?>
                           
                            <span class="text-28"><?php echo $arab_filter_secondary_label . " " .$arab_country_data->post_title; ?> المعتمدة خلال عام <?php echo $arab_filter_year; ?></span>
                           
                       <?php }else{?>
                            <span class="text-28"><?php echo $arab_country_data->post_title . "'s " . $arab_filter_secondary_label;?> during year <?php echo $arab_filter_year;?></span>
                       <?php }
                        ?>   
                    <?php }?>
                    <?php if ( empty($arab_filter_year) && !empty($arab_filter_country) && !empty($arab_filter_sector)) {
                       
                        $arab_sector_data = get_post( $arab_filter_sector );?>
                        
                        <span class="text-28"><?php echo $arab_filter_secondary_label . " for " . $arab_country_data->post_title . " in the " . $arab_sector_data->post_title . " sector "; ?> <?php echo $country_label_heading;?></span>
                        
                    <?php }?>
                    <?php if ( empty($arab_filter_year) && empty($arab_filter_country) && empty($arab_filter_sector)) {?>
                        <span class="text-28"><?php echo $arab_filter_secondary_label ?></span>
                    <?php } ?>
                     <span class="text-28"><?php echo arabfund_plugin_str_display('(Amounts in thousand KD)'); ?></span>
                 </div>
                 <div class="county-info d-flex align-items-center">
                    <?php if( !empty( $arab_heading_label ) ) { ?>
                        <span class="text-28"><?php echo $arab_heading_label; ?></span>
                     <?php } if( !empty( $arab_filter_country) ) { ?>
                        <div class="rectangle-flag">
                            <img src="<?php echo get_the_post_thumbnail_url($arab_filter_country, 'full'); ?>" alt="flag">
                        </div>
                    <?php } ?>    
              </div>
             </div>   
             <div>
                 <table class="summary-table">
                     <thead>
                         <tr>
                             <th class="th"><?php echo arabfund_plugin_str_display('Sr No'); ?></th>
                             <?php if( $arab_project_type != 'contribution' ) { ?>
                                <?php if( $arab_project_type == 'grant' ) { ?>
                                    <th class="th text-right"><?php echo arabfund_plugin_str_display('Grant number'); ?></th>
                                <?php } else { ?>
                                    <th class="th text-right"><?php echo arabfund_plugin_str_display('Loan number'); ?></th>
                                <?php } ?>    
                                <th class="th"><?php echo arabfund_plugin_str_display('The Project'); ?></th>
                                <th class="th text-right"><?php echo arabfund_plugin_str_display('Sector'); ?></th>
                                <th class="th"><?php echo arabfund_plugin_str_display('General Approval'); ?></th>
                                <th class="th text-right"><?php echo arabfund_plugin_str_display('Country'); ?></th>                               
                                <th class="th"><?php echo arabfund_plugin_str_display('Original Amount'); ?></th>
                                 <th class="th"><?php echo arabfund_plugin_str_display('Amount cancelled'); ?></th>
                                 <th class="th"><?php echo arabfund_plugin_str_display('Net amount'); ?></th>
                             <?php } if( $arab_project_type == 'contribution' ) { ?>
                                <th class="th"><?php echo arabfund_plugin_str_display('Start Date'); ?></th>
                                <th class="th text-right"><?php echo arabfund_plugin_str_display('Country'); ?></th>                                
                                <th class="th"><?php echo arabfund_plugin_str_display('The Project'); ?></th>
                                <th class="th"><?php echo arabfund_plugin_str_display('Amount Paid'); ?></th> 
                            <?php } ?>
                            
                         </tr>
                     </thead>
                     <tbody>
                     <?php  foreach( $arab_available_projects['projects_loan'] as $key => $project_data ) {

                                $project_loan_number   = get_field('project_loan_number',$project_data->ID);
                                $project_approved_year = get_field('project_approved_year',$project_data->ID); 

                                $project_orignal_amount = get_field('project_original_amount',$project_data->ID);
                                $project_cancelled_amount = get_field('project_cancelled_amount',$project_data->ID);
                                $project_net_amount = get_field('project_net_amount',$project_data->ID);
                                $project_amount_paid = get_field('project_amount_paid',$project_data->ID);
                                $project_sector     = get_field('project_sector',$project_data->ID);
                                $project_country    = get_field('project_country',$project_data->ID);
                                $project_start_date =  get_field('project_start_date',$project_data->ID);
                                $project_country_title = get_the_title($project_country);

                                if($project_cancelled_amount == "" || $project_cancelled_amount === 'NULL' ||  $project_cancelled_amount == null){
                                    $project_cancelled_amount = 0.000;
                                }
                                if( is_numeric( $project_orignal_amount ) && is_numeric( $project_cancelled_amount ) && is_numeric( $project_net_amount ) ) {
                                  
                                    $project_orignal_amount = ( $project_orignal_amount / 1000 );
                                    $project_cancelled_amount = ( $project_cancelled_amount / 1000 );
                                    $project_net_amount = ( $project_net_amount / 1000 );
    
                                    $project_orignal_amount = number_format(round($project_orignal_amount), 2, '.', ',');
                                    // Remove the decimal part if it's .00
                                    $project_orignal_amount = rtrim($project_orignal_amount, '0');
                                    $project_orignal_amount = rtrim($project_orignal_amount, '.');
    
                                    $project_cancelled_amount = number_format(round($project_cancelled_amount), 2, '.', ',');
                                    // Remove the decimal part if it's .00
                                    $project_cancelled_amount = rtrim($project_cancelled_amount, '0');
                                    $project_cancelled_amount = rtrim($project_cancelled_amount, '.');
    
                                    $project_net_amount = number_format(round($project_net_amount), 2, '.', ',');
                                    // Remove the decimal part if it's .00
                                    $project_net_amount = rtrim($project_net_amount, '0');
                                    $project_net_amount = rtrim($project_net_amount, '.');  
                                }

                                if( is_numeric( $project_amount_paid ) ) {
                                    $project_amount_paid = ( $project_amount_paid / 1000 );

                                    $project_amount_paid  = number_format(round($project_amount_paid) , 2, '.', ',');
                                    // Remove the decimal part if it's .00
                                    $project_amount_paid  = rtrim($project_amount_paid , '0');
                                    $project_amount_paid  = rtrim($project_amount_paid , '.');
                                }
                        ?>   
                            <tr class="list-item">
                                <td class="td"><?php echo ( $key + 1 ); ?></td>
                                <?php if( $arab_project_type != 'contribution' ) { ?> 
                                <td class="td"><?php echo $project_loan_number; ?></td>
                                <td class="td text-right project-name">
                                <?php
                                    $current_language_post_id = pll_get_post($project_data->ID);
                                    $current_language_post_url = get_permalink($current_language_post_id);
                                    $current_language_post_content = $project_data->post_content;
                                    if($current_language_post_content !== ""){
                                        ?>
                                        <a href="<?php echo $current_language_post_url; ?>"><?php echo $project_data->post_title; ?></a>
                                   <?php }else {
                                         echo $project_data->post_title;
                                    }
                                    ?>
                                    <!-- <a href="<?php echo $current_language_post_url; ?>"><?php echo $project_data->post_title; ?></a> -->
                                </td>
                                   <td class="td text-right"><?php echo arabfund_plugin_str_display(get_the_title($project_sector)); ?></td>
                                   <td class="td"><?php echo $project_approved_year; ?></td>
                                   <td class="td text-right"><?php echo $project_country_title; ?></td>
                                   <td class="td"><?php echo $project_orignal_amount; ?></td>
                                    <td class="td">
                                        <?php if($project_cancelled_amount === 'NULL' || $project_cancelled_amount == null || $project_cancelled_amount == 0) {
                                            echo "-";
                                    } else{
                                        echo $project_cancelled_amount;
                                    }?></td>
                                    <td class="td"><?php echo $project_net_amount; ?></td>
                                <?php } if( $arab_project_type == 'contribution' ) { ?>
                                    <td class="td"><?php echo $project_start_date; ?></td> 
                                    <td class="td text-right"><?php echo $project_country_title; ?></td>
                                    <td class="td text-right project-name">
                                    <?php
                                        $current_language_post_id = pll_get_post($project_data->ID);
                                        $current_language_post_url = get_permalink($current_language_post_id);
                                        $current_language_post_content = $project_data->post_content;
                                        if($current_language_post_content !== ""){
                                            ?>
                                            <a href="<?php echo $current_language_post_url; ?>"><?php echo $project_data->post_title; ?></a>
                                    <?php }else {
                                            echo $project_data->post_title;
                                        }
                                        ?>
                                        <!-- <a href="<?php echo $current_language_post_url; ?>"><?php echo $project_data->post_title; ?></a> -->
                                    </td>
                                    <td class="td"><?php echo $project_amount_paid; ?></td>
                                <?php }  ?>
                            </tr>
                      <?php }  ?> 
                     </tbody>
                     <tfoot>
                         <tr>
                         <?php if( $arab_project_type != 'contribution' ) { ?>
                             <th class="th"> </th>
                             <th class="th text-right"><?php echo arabfund_plugin_str_display('the total'); ?></th>
                             <th class="th"> </th>
                             <th class="th text-right"></th>
                             <th class="th"> </th>  
                             <th class="th"> </th>
                             <th class="th"><?php echo $arab_available_projects['projects_amount']; ?></th>
                             <th class="th"><?php echo $arab_available_projects['projects_cancelled_amount']; ?></th>
                             <th class="th"><?php echo $arab_available_projects['projects_net_amount']; ?></th>                            
                             <?php } else if( $arab_project_type == 'contribution' ) { ?> 
                                <th class="th"> </th>    
                                <th class="th"> </th>
                                <th class="th"> </th> 
                                <th class="th"> </th> 
                                <th class="th"><?php echo $arab_available_projects['project_amount_paid']; ?></th>
                             <?php } ?>
                         </tr>
                     </tfoot>
                 </table>
             </div>
             <div id="pagination-container"></div>
            <?php
        } else {
            ?>
                <p><?php echo esc_html(arabfund_plugin_str_display('No projects were found according to the search criteria.'))?></p>
            <?php
        }
    }
    $html = ob_get_clean();
    wp_send_json(array('html' => $html),200,JSON_UNESCAPED_UNICODE);
}
add_action('wp_ajax_nopriv_arab_project_filter', 'arab_funds_show_projects_listing');
add_action('wp_ajax_arab_project_filter', 'arab_funds_show_projects_listing');

/** Custom functionality to load training videos on ajax */
function arab_funds_load_training_videos(){

    $current_language = pll_current_language();  
    ob_start();
    switch_to_blog(3);
    if(!empty($_POST['section_id']) && !empty($_POST['training_id'])) {
    
        $section_details = !empty( $_POST['section_id'] ) ? explode("-",$_POST['section_id']) : '';
        $trainings       = arab_funds_get_trainings_by_section( $current_language , $section_details[1] , $_POST['training_id'] );
        if( !empty( $trainings ) && is_array( $trainings ) ) {

            $item_count = count($trainings);
    ?>
    <div class="events_container listed-topics-wrap">
                            <?php foreach( $trainings as $key => $training_data ) {
                                    $traing_file_data    = get_field('topic_file',$training_data->ID);
                                    $media_type = get_field('source_type',$training_data->ID);
                                    if ( $media_type == 'file' ) {
                                        if($traing_file_data['type'] == 'video'){?>
                                            <div class="event_box">
                                                <?php if( !empty($traing_file_data['url']) ) { 
                                                    
                                                    $display_image = wp_get_attachment_image_src( get_post_thumbnail_id( $training_data->ID ), 'full' );
                                                    if(!empty($display_image) && is_array($display_image)) {
                                                            $display_image = $display_image[0];
                                                    } else {
                                                            $display_image = "/wp-content/uploads/2023/11/news_img.jpg";
                                                    }
                                                    ?>
                                                    <div class="event_image training-item" data-video-path="<?php echo $traing_file_data['url']; ?>">
                                                        <img src="<?php echo $display_image; ?>" alt="<?php echo $training_data->post_title; ?>">
                                                    </div>
                                                <?php } ?>    
                                                <div class="program_card">
                                                    <?php echo $training_data->post_title; ?>                                       
                                                </div>
                                            </div>
                                        <?php
                                        }else if($traing_file_data['type'] == 'application'){?>
                                        <div class="event_box">
                                            <?php if( !empty($traing_file_data['url']) ) { 

                                                    $display_image = wp_get_attachment_image_src( get_post_thumbnail_id( $training_data->ID ), 'full' );
                                                    if(!empty($display_image) && is_array($display_image)) {
                                                            $display_image = $display_image[0];
                                                    } else {
                                                            $display_image = site_url() . '/wp-content/themes/hello-elementor-child/assets/images/noimg_logo.jpg';
                                                    }

                                                ?>
                                                <div class="event_image">
                                                    <a href="<?php echo $traing_file_data['url']; ?>" target="_blank">
                                                    <img src="<?php echo $display_image; ?>" alt="<?php echo $training_data->post_title; ?>">
                                                    </a>
                                                </div>
                                            <?php } ?>    
                                            <div class="program_card">
                                                <?php echo $training_data->post_title; ?>                                        
                                            </div>
                                        </div>
                                    <?php  }
                                       } else {
                                        $video_url =  get_field('video_url',$training_data->ID);
                                    ?>   
                                    <div class="event_box">
                                            <?php if( !empty($video_url) ) { 
                                                
                                                $display_image = wp_get_attachment_image_src( get_post_thumbnail_id( $training_data->ID ), 'full' );
                                                if(!empty($display_image) && is_array($display_image)) {
                                                        $display_image = $display_image[0];
                                                } else {
                                                        $display_image = "/wp-content/uploads/2023/11/news_img.jpg";
                                                }  

                                                ?>
                                                <a class="event_image training-item-youtube" href="<?php echo $video_url; ?>">
                                                    <img src="<?php echo $display_image; ?>" alt="<?php echo $training_data->post_title; ?>">
                                                </a>
                                            <?php } ?>    
                                            <div class="program_card">
                                                <?php echo $training_data->post_title; ?>                                    
                                            </div>
                                    </div>
         <?php } 
        } ?>
         <div id="event-pagination"></div>    
        </div>
        
        <div id="video-popup" class="mfp-hide">
            <div class="mfp-content">
                <video controls>
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    <?php }
    }        
     restore_current_blog();
    $html = ob_get_clean();
    wp_send_json(array('html' => $html,'count' => $item_count),200,JSON_UNESCAPED_UNICODE);

}
add_action('wp_ajax_nopriv_arab_trainings', 'arab_funds_load_training_videos');
add_action('wp_ajax_arab_trainings', 'arab_funds_load_training_videos');



/**Start new load more implementation for countries */

function arab_funds_load_more_countries() {

    $offset = ($_POST['paged'] - 1) * 8;
    $lang = $_POST['lang'];
    $current_language = pll_current_language();
    
    $ajaxposts = new WP_Query([
        'post_type'      => 'countries',
        'posts_per_page' => 8,
        'offset'         => $offset,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'lang'           => $lang,
        'paged'          => $_POST['paged'],
        'post_status'    => 'publish',
    ]);

    $response = '';
    $max_pages = $ajaxposts->max_num_pages;
    if ($ajaxposts->have_posts()) {
        ob_start();
        while ($ajaxposts->have_posts()) : $ajaxposts->the_post();

            $country_title = get_the_title();
            $country_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

            $country_signed_loans_data = arab_funds_display_data_country_project_type(get_the_ID(), 'loan');
            $country_grants_data = arab_funds_display_data_country_project_type(get_the_ID(), 'grant');
            $current_language = pll_current_language(); // Get the current language

            // Check if the current language is English
            if ($current_language === 'en-us') {
                $country_loans_url   = get_site_url() . '/overview/list-of-all-projects?ptype=loan&cid=' . get_the_ID();
                $country_grants_url  = get_site_url() . '/overview/list-of-all-projects?ptype=grant&cid=' . get_the_ID();
            } else {
                $country_loans_url   = get_site_url() . '/' . $current_language . '/afesd-activities/list-of-all-projects?ptype=loan&cid=' . get_the_ID();
                $country_grants_url  = get_site_url() . '/' . $current_language . '/afesd-activities/list-of-all-projects?ptype=grant&cid=' . get_the_ID();
            } ?>

            <div class="country-card">
                <div class="country-flag">
                    <div class="flag-img">
                        <img src="<?php echo $country_image_url; ?>" alt="">
                    </div>
                    <p class="text-26"><?php echo $country_title; ?></p>
                </div>
                <div class="line"></div>
                <p class="country-flag-title text-21 text-center"><?php echo arabfund_plugin_str_display("SIGNED LOANS"); ?></p>
                <div class="line"></div>
                <div class="country-flag-info d-flex justify-content-around align-items-center">
                    <div class="anchor-green-underline">
                        <p class="text-21 text-gray al-jazeera-regular"><?php echo arabfund_plugin_str_display("NUMBER"); ?></p>
                        <a class="text-28 text-success text-underline-green" href="<?php echo $country_loans_url; ?>"><?php echo $country_signed_loans_data["projects_count"]; ?></a>
                    </div>
                    <div class="anchor-green-underline">
                        <p class="text-19 al-jazeera-regular"><?php echo arabfund_plugin_str_display("VALUES"); ?></p>
                        <p class="text-28 "><?php echo $country_signed_loans_data["projects_amount"]; ?></p>
                        <p class="text-15 al-jazeera-regular"><?php echo arabfund_plugin_str_display("One thousand KD*"); ?></p>
                    </div>
                </div>
                <div class="line"></div>
                <p class="country-flag-title text-21 text-center"><?php echo arabfund_plugin_str_display("EXTENDED GRANTS"); ?></p>
                <div class="line"></div>
                <div class="country-flag-info d-flex justify-content-around align-items-center">
                    <div class="anchor-green-underline">
                        <p class="text-21 text-gray al-jazeera-regular"><?php echo arabfund_plugin_str_display('NUMBER'); ?></p>
                        <a class="text-28 text-success text-underline-green" href="<?php echo $country_grants_url; ?>"><?php echo $country_grants_data["projects_count"]; ?></a>
                    </div>
                    <div class="anchor-green-underline">
                        <p class="text-19 al-jazeera-regular"><?php echo arabfund_plugin_str_display("VALUES"); ?></p>
                        <p class="text-28 "><?php echo $country_grants_data["projects_amount"]; ?></p>
                        <p class="text-15 al-jazeera-regular"><?php echo arabfund_plugin_str_display("One thousand KD*"); ?></p>
                    </div>
                </div>
                <div class="read-more d-flex align-items-center ">
                <?php if ($current_language == 'ar'){?>
                    <a class="text-19 al-jazeera-regular link right-to-left" href="<?php echo get_the_permalink(); ?>"><?php echo arabfund_plugin_str_display("اقرأ أكثر"); ?></a>
                <?php }else {?>
                    <a class="text-19 al-jazeera-regular link right-to-left" href="<?php echo get_the_permalink(); ?>"><?php echo arabfund_plugin_str_display('Read More'); ?></a>
                <?php }?>
                <?php if ($current_language == 'ar'){?>
                    <div class="icon-circle green-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20.243" height="13.501" viewBox="0 0 20.243 13.501">
                            <path id="Icon_ionic-ios-arrow-round-back" data-name="Icon ionic-ios-arrow-round-back" d="M15.216,11.51a.919.919,0,0,1,.007,1.294l-4.268,4.282H27.218a.914.914,0,0,1,0,1.828H10.955L15.23,23.2a.925.925,0,0,1-.007,1.294.91.91,0,0,1-1.287-.007L8.142,18.647h0a1.026,1.026,0,0,1-.19-.288.872.872,0,0,1-.07-.352.916.916,0,0,1,.26-.64l5.794-5.836A.9.9,0,0,1,15.216,11.51Z" transform="translate(-7.882 -11.252)" fill="#029b47" />
                        </svg>
                    </div>
                <?php } else {?>
                    <div class="icon-circle rotate-arrow green-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20.243" height="13.501" viewBox="0 0 20.243 13.501">
                            <path id="Icon_ionic-ios-arrow-round-back" data-name="Icon ionic-ios-arrow-round-back" d="M15.216,11.51a.919.919,0,0,1,.007,1.294l-4.268,4.282H27.218a.914.914,0,0,1,0,1.828H10.955L15.23,23.2a.925.925,0,0,1-.007,1.294.91.91,0,0,1-1.287-.007L8.142,18.647h0a1.026,1.026,0,0,1-.19-.288.872.872,0,0,1-.07-.352.916.916,0,0,1,.26-.64l5.794-5.836A.9.9,0,0,1,15.216,11.51Z" transform="translate(-7.882 -11.252)" fill="#029b47" />
                        </svg>
                    </div>
               <?php }?>
                </div>
            </div> 
           <?php
            endwhile;
        } 
        $html = ob_get_clean();
        
        wp_reset_postdata();
        wp_send_json(array('max' => $max_pages, 'html' => $html),200,JSON_UNESCAPED_UNICODE);

}
add_action('wp_ajax_arab_funds_load_more_countries', 'arab_funds_load_more_countries');
add_action('wp_ajax_nopriv_arab_funds_load_more_countries', 'arab_funds_load_more_countries');

/**End new load more implementation for countries */
function arab_detect_language( $string ) {
    $arabicChars = ['ا', 'ب', 'ت', 'ث', 'ج', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ك', 'ل', 'م', 'ن', 'ه', 'و', 'ي'];
    $englishChars = range('a', 'z');

    // Count the occurrences of Arabic and English characters in the string
    $arabicCount = count(array_intersect(str_split($string), $arabicChars));
    $englishCount = count(array_intersect(str_split($string), $englishChars));

    // Compare the counts to determine the dominant language
    if ($arabicCount > $englishCount) {
        return 'ar';
    } elseif ($englishCount > $arabicCount) {
        return 'en-us';
    }

    return 'Unknown';
}