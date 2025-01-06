<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin Class
 *
 * Manage Admin Panel Class
 *
 * @package Arab Funds
 * @since 1.0.0
 */

class Arab_Funds_Shortcodes
{

    public $scripts;

    //class constructor
    public function __construct()
    {

        global $arab_funds_scripts;

        $this->scripts = $arab_funds_scripts;
    }

    /**
     * Shortcode displaying all the types of projects/loan details
     *
     * @package Arab Funds
     * @since 1.0.0
     */

    public function arab_funds_projects_summary_data()
    {

        ob_start();

        $arab_funds_grants_data = arab_funds_total_count_loan_sum('grant');
        $arab_funds_loans_data = arab_funds_total_count_loan_sum('loan');
        $arab_funds_private_data = arab_funds_total_count_loan_sum('private');

        //formatting grants sum
        //$arab_funds_grant_sum = number_format($arab_funds_grants_data['projects_amount'], 2, '.', ',');
        $arab_funds_grant_sum = number_format(round($arab_funds_grants_data['projects_amount']), 0, '.', ',');

        // Remove the decimal part if it's .00
        $arab_funds_grant_sum = rtrim($arab_funds_grant_sum, '0');
        $arab_funds_grant_sum = rtrim($arab_funds_grant_sum, '.');

        //formatting loan sum
        $arab_funds_loans_sum = number_format($arab_funds_loans_data['projects_amount'], 2, '.', ',');
        // Remove the decimal part if it's .00
        $arab_funds_loans_sum = rtrim($arab_funds_loans_sum, '0');
        $arab_funds_loans_sum = rtrim($arab_funds_loans_sum, '.');

        //formatting private sum
        $arab_funds_private_sum = number_format(round($arab_funds_private_data['projects_amount']), 0, '.', ',');
        // Remove the decimal part if it's .00
        $arab_funds_private_sum = rtrim($arab_funds_private_sum, '0');
        $arab_funds_private_sum = rtrim($arab_funds_private_sum, '.');

        ?>
        <div class="summary-cards">
            <div class="summary-card">
                <p class="card-title"><?php echo arabfund_plugin_str_display('TOTAL LOANS MADE') ?></p>
                <div class="d-flex">
                    <div class="card-icon"><img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-loan.svg"; ?>" alt=""></div>
                    <div class="card-content">
                        <div>
                            <p class="card-subtitle"><?php echo arabfund_plugin_str_display('NUMBER') ?></p>
                            <p class="card-numbers"><?php echo $arab_funds_loans_data['projects_count']; ?></p>
                        </div>
                        <div>
                            <p class="card-subtitle"><?php echo arabfund_plugin_str_display('Amount (thousand KWD)') ?></p>
                            <p class="card-numbers"><?php echo $arab_funds_loans_sum; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="summary-card">
                <p class="card-title"><?php echo arabfund_plugin_str_display('THE AID PROVIDED IS TOTAL') ?></p>
                <div class="d-flex">
                    <div class="card-icon"><img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-money.svg"; ?>" alt=""></div>
                    <div class="card-content">
                        <div>
                            <p class="card-subtitle"><?php echo arabfund_plugin_str_display('NUMBER') ?></p>
                            <p class="card-numbers"><?php echo $arab_funds_grants_data['projects_count']; ?></p>
                        </div>
                        <div>
                            <p class="card-subtitle"><?php echo arabfund_plugin_str_display('Amount (thousand KWD)') ?></p>
                            <p class="card-numbers"><?php echo $arab_funds_grant_sum; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="summary-card">
                <p class="card-title"><?php echo arabfund_plugin_str_display('PRIVATE SECTOR') ?></p>
                <div class="d-flex">
                    <div class="card-icon"><img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-project-management.svg"; ?>"
                            alt=""></div>
                    <div class="card-content">
                        <div>
                            <p class="card-subtitle"><?php echo arabfund_plugin_str_display('NUMBER') ?></p>
                            <p class="card-numbers"><?php echo $arab_funds_private_data['projects_count']; ?></p>
                        </div>
                        <div>
                            <p class="card-subtitle"><?php echo arabfund_plugin_str_display('Amount (thousand KWD)') ?></p>
                            <p class="card-numbers"><?php echo $arab_funds_private_sum; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Shortcode displaying all the countries with it's initial details
     *
     * @package Arab Funds
     * @since 1.0.0
     */

    public function arab_funds_countries_listing_data()
    {

        ob_start();
        $current_language = pll_current_language();
        $args = array(
            'post_type' => 'countries',           // Your custom post type name
            'post_status' => 'publish',
            'posts_per_page' => 8,
            'lang' => $current_language,
            'order' => 'ASC',
            'orderby' => 'title',
        );
        $country_data = new WP_Query($args);
        $country_primary_heading = get_field('project_summary_heading_primary', get_the_ID());
        $country_primary_secondary = get_field('project_summary_heading_secondary', get_the_ID());
        // $country_data = arab_funds_total_countries_display();
        // pll_register_string( '1-kwd-equi', '(٭) 1 KWD Equivalent of about 3.3 US dollars', 'arab-funds', false );
        // pll_register_string( 'financing-activities', 'Private sector - financing activities as of 12/31/2021', 'arab-funds', false );
        // pll_register_string( 'equivalent-amount', '(٭) The equivalent amount in Kuwaiti dinars according to the conversion rate upon payment (٭) 1 K. Equivalent to about 3.3 US dollars', 'arab-funds', false );
        ?>
        <div class="country_container">
            <div>
                <p class="summary-note">
                    <?php echo arabfund_plugin_str_display('(٭) 1 KWD Equivalent of about 3.3 US dollars') ?>
                </p>
            </div>
            <div class="filter-section">
                <div>
                    <?php if (!empty($country_primary_heading)) { ?>
                        <!--<p class="text-28"><?php echo arabfund_plugin_str_display('Private sector - financing activities as of 12/31/2021'); ?></p>-->
                        <p class="text-28"><?php echo $country_primary_heading; ?></p>
                    <?php }
                    if (!empty($country_primary_secondary)) { ?>
                        <div>
                            <!--<span class="text-16 "><?php echo arabfund_plugin_str_display('(٭) 1 KWD Equivalent of about 3.3 US dollars') ?></span>
                    <span class="text-16 "><?php echo arabfund_plugin_str_display('(٭٭) The equivalent amount in Kuwaiti dinars according to the conversion rate
		Upon payment') ?></span>-->
                            <span class="text-16 "><?php echo $country_primary_secondary; ?></span>
                        </div>
                    <?php } ?>
                </div>

                <div class="form-container">
                    <div class="search-bar-container active">

                        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27.007" viewBox="0 0 27 27.007"
                            class="magnifier search-btn">
                            <path id="Icon_ionic-ios-search" data-name="Icon ionic-ios-search"
                                d="M31.184,29.545l-7.509-7.58a10.7,10.7,0,1,0-1.624,1.645l7.46,7.53a1.156,1.156,0,0,0,1.631.042A1.163,1.163,0,0,0,31.184,29.545ZM15.265,23.7a8.45,8.45,0,1,1,5.977-2.475A8.4,8.4,0,0,1,15.265,23.7Z"
                                transform="translate(-4.5 -4.493)" />
                        </svg>
                        <input type="text" class="search-input" id="search-country" data-lang="<?php echo $current_language; ?>"
                            placeholder="<?php echo arabfund_plugin_str_display('Search') ?> " />
                        <div class="valid-msg"></div>
                        <div class="clear-icon-container" style="display:none;" id="clear-search">X</div>
                    </div>

                </div>
            </div>
            <div id="loader-search">
                <img alt="Loading..." src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arab-loader.svg'; ?>">
            </div>
            <div class="country-cards">
                <?php if ($country_data->have_posts()) {
                    while ($country_data->have_posts()) {
                        $country_data->the_post();
                        $country_title = get_the_title();
                        $country_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

                        $country_signed_loans_data = arab_funds_display_data_country_project_type(get_the_ID(), 'loan');
                        //formatting signed loans sum
                        //$country_loans_sum = number_format($country_signed_loans_data['projects_amount'], 2, '.', ',');
                        // Remove the decimal part if it's .00
                        //$country_loans_sum = rtrim($country_loans_sum, '0');
                        //$country_loans_sum = rtrim($country_loans_sum, '.');
                        $country_grants_data = arab_funds_display_data_country_project_type(get_the_ID(), 'grant');
                        //echo $country_grants_data['projects_amount'];
                        // $projects_amount = floatval($country_grants_data['projects_amount']);
                        // $rounded_amount = round($projects_amount);
                        // $country_grants_sum = number_format($rounded_amount, 2, '.', ',');
        
                        $current_language = pll_current_language(); // Get the current language
        
                        // Check if the current language is English
                        if ($current_language === 'en-us') {
                            $country_loans_url = get_site_url() . '/overview/list-of-all-projects?ptype=loan&cid=' . get_the_ID();
                            $country_grants_url = get_site_url() . '/overview/list-of-all-projects?ptype=grant&cid=' . get_the_ID();
                        } else {
                            $country_loans_url = get_site_url() . '/' . $current_language . '/afesd-activities/list-of-all-projects?ptype=loan&cid=' . get_the_ID();
                            $country_grants_url = get_site_url() . '/' . $current_language . '/afesd-activities/list-of-all-projects?ptype=grant&cid=' . get_the_ID();
                        }




                        //formatting signed loans sum
                        //$country_grants_sum = number_format($country_grants_data['projects_amount'], 2, '.', ',');
                        // Remove the decimal part if it's .00
                        //$country_grants_sum = rtrim($country_grants_sum, '0');
                        //$country_grants_sum = rtrim($country_grants_sum, '.'); ?>
                        <div class="country-card">
                            <div class="country-flag">
                                <div class="flag-img">
                                    <img src="<?php echo $country_image_url; ?>" alt="">

                                </div>
                                <p class="text-26"><?php echo $country_title; ?></p>
                            </div>
                            <div class="line"></div>
                            <p class="country-flag-title text-21 text-center"><?php echo arabfund_plugin_str_display('SIGNED LOANS') ?>
                            </p>
                            <div class="line"></div>
                            <div class="country-flag-info d-flex justify-content-around align-items-center">
                                <div class="anchor-green-underline">
                                    <p class="text-21 text-gray "><?php echo arabfund_plugin_str_display('NUMBER') ?></p>
                                    <a class="text-28 text-success text-underline-green"
                                        href="<?php echo $country_loans_url; ?>"><?php echo $country_signed_loans_data['projects_count']; ?></a>
                                </div>
                                <div class="anchor-green-underline">
                                    <p class="text-19 "><?php echo arabfund_plugin_str_display('VALUES') ?></p>
                                    <p class="text-28 "><?php echo $country_signed_loans_data['projects_amount']; ?></p>
                                    <p class="text-15 "><?php echo arabfund_plugin_str_display('One thousand KD*') ?></p>
                                </div>
                            </div>
                            <div class="line"></div>
                            <p class="country-flag-title text-21 text-center">
                                <?php echo arabfund_plugin_str_display('EXTENDED GRANTS') ?>
                            </p>
                            <div class="line"></div>
                            <div class="country-flag-info d-flex justify-content-around align-items-center">
                                <div class="anchor-green-underline">
                                    <p class="text-21 text-gray "><?php echo arabfund_plugin_str_display('NUMBER') ?></p>
                                    <a class="text-28 text-success text-underline-green"
                                        href="<?php echo $country_grants_url; ?>"><?php echo $country_grants_data['projects_count']; ?></a>
                                </div>
                                <div class="anchor-green-underline">
                                    <p class="text-19 "><?php echo arabfund_plugin_str_display('VALUES') ?></p>
                                    <p class="text-28 "><?php echo $country_grants_data['projects_amount']; ?></p>
                                    <p class="text-15 "><?php echo arabfund_plugin_str_display('One thousand KD*') ?></p>
                                </div>
                            </div>
                            <div class="read-more d-flex align-items-center ">
                                <!-- <p class="text-19  link right-to-left">اقرأ أكثر</p> -->
                                <?php if ($current_language == 'ar') { ?>
                                    <a class="text-19  link right-to-left" href="<?php echo get_the_permalink(); ?>">اقرأ أكثر</a>

                                <?php } else { ?>
                                    <a class="text-19  link right-to-left"
                                        href="<?php echo get_the_permalink(); ?>"><?php echo arabfund_plugin_str_display('Read More'); ?></a>

                                <?php } ?>
                                <?php if ($current_language == 'ar') { ?>
                                    <div class="icon-circle green-circle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20.243" height="13.501" viewBox="0 0 20.243 13.501">
                                            <path id="Icon_ionic-ios-arrow-round-back" data-name="Icon ionic-ios-arrow-round-back"
                                                d="M15.216,11.51a.919.919,0,0,1,.007,1.294l-4.268,4.282H27.218a.914.914,0,0,1,0,1.828H10.955L15.23,23.2a.925.925,0,0,1-.007,1.294.91.91,0,0,1-1.287-.007L8.142,18.647h0a1.026,1.026,0,0,1-.19-.288.872.872,0,0,1-.07-.352.916.916,0,0,1,.26-.64l5.794-5.836A.9.9,0,0,1,15.216,11.51Z"
                                                transform="translate(-7.882 -11.252)" fill="#029b47" />
                                        </svg>

                                    </div>
                                <?php } else { ?>
                                    <div class="icon-circle rotate-arrow green-circle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20.243" height="13.501" viewBox="0 0 20.243 13.501">
                                            <path id="Icon_ionic-ios-arrow-round-back" data-name="Icon ionic-ios-arrow-round-back"
                                                d="M15.216,11.51a.919.919,0,0,1,.007,1.294l-4.268,4.282H27.218a.914.914,0,0,1,0,1.828H10.955L15.23,23.2a.925.925,0,0,1-.007,1.294.91.91,0,0,1-1.287-.007L8.142,18.647h0a1.026,1.026,0,0,1-.19-.288.872.872,0,0,1-.07-.352.916.916,0,0,1,.26-.64l5.794-5.836A.9.9,0,0,1,15.216,11.51Z"
                                                transform="translate(-7.882 -11.252)" fill="#029b47" />
                                        </svg>

                                    </div>
                                <?php } ?>
                            </div>
                        </div><?php
                    }
                    wp_reset_postdata();
                }
                ?>
            </div>
            <div id="loader">
                <img alt="Loading..." src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arab-loader.svg'; ?>">
            </div>
            <button id="load-more-btn" class="view-more" data-lang="<?php echo $current_language; ?>"><span
                    class="text-24 text-success"><?php echo arabfund_plugin_str_display('Show more'); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14.069" height="25.311" viewBox="0 0 14.069 25.311">
                    <path id="Path_135797" data-name="Path 135797" d="M11.948,0,0,11.948,11.948,23.9"
                        transform="translate(1.414 0.707)" fill="none" stroke="#029b47" stroke-width="2" />
                </svg>

            </button>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Shortcode displaying indivisual details of every country
     *
     * @package Arab Funds
     * @since 1.0.0
     */

    public function arab_funds_country_all_single_details()
    {
        ob_start();
        $current_country_id = get_the_ID();
        $current_language = pll_current_language();
        $country_image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
        $country_latest_macros = get_field('country_macros');
        $latest_macros = !empty($country_latest_macros) ? end($country_latest_macros) : array();
        //$arab_country_gdp_current = !empty($latest_macros['country_gdp_current']) ? $latest_macros['country_gdp_current'] : 0;
        //$arab_country_gdp_current = !empty($latest_macros['country_gdp_current']) ? $latest_macros['country_gdp_current'] : 0;
        $arab_country_gdp_current = isset($latest_macros['country_gdp_current']) ? $latest_macros['country_gdp_current'] : 0;
        $arab_country_gdp_current = is_numeric($arab_country_gdp_current) ? $arab_country_gdp_current : 0;
        $arab_country_gdp_per_capita = !empty($latest_macros['country_gdp_per_capita']) ? $latest_macros['country_gdp_per_capita'] : 0;
        $arab_country_gdp_per_capita = is_numeric($arab_country_gdp_per_capita) ? $arab_country_gdp_per_capita : 0;
        $arab_country_real_gdp_growth = !empty($latest_macros['country_real_growth_rate']) ? $latest_macros['country_real_growth_rate'] : 0;
        $arab_country_inflation_rate = !empty($latest_macros['country_inflation_rate']) ? $latest_macros['country_inflation_rate'] : 0;
        $arab_country_current_country_balance = !empty($latest_macros['country_current_account_balance']) ? $latest_macros['country_current_account_balance'] : 0;

        $arab_country_ariculture_value_added = !empty($latest_macros['country_agri_value_added']) ? $latest_macros['country_agri_value_added'] : 0;
        $arab_country_extractive_value_added = !empty($latest_macros['country_extractive_industries']) ? $latest_macros['country_extractive_industries'] : 0;
        $arab_country_manufacturing_value_added = !empty($latest_macros['country_manufacturing_industries']) ? $latest_macros['country_manufacturing_industries'] : 0;
        $arab_country_service_sector_value_added = !empty($latest_macros['country_service_sector']) ? $latest_macros['country_service_sector'] : 0;

        $arab_country_access_health_services = !empty($latest_macros['country_access_heath_services']) ? $latest_macros['country_access_heath_services'] : 0;
        $arab_country_access_safe_drinking_water = !empty($latest_macros['country_safe_drinking_water']) ? $latest_macros['country_safe_drinking_water'] : 0;
        $arab_country_sanitation_facilities = !empty($latest_macros['country_sanitation_facilities']) ? $latest_macros['country_sanitation_facilities'] : 0;

        $arab_country_labor_force = !empty($latest_macros['country_labor_force']) ? $latest_macros['country_labor_force'] : 0;

        $arab_country_area_sq_kms = !empty($latest_macros['country_area_kms']) ? $latest_macros['country_area_kms'] : 0;
        $arab_country_area_sq_kms = is_numeric($arab_country_area_sq_kms) ? $arab_country_area_sq_kms : 0;
        $arab_country_population = !empty($latest_macros['country_population']) ? $latest_macros['country_population'] : 0;

        //GDP Current Country
        $arab_country_gdp_current = number_format($arab_country_gdp_current, 2, '.', ',');
        // Remove the decimal part if it's .00
        $arab_country_gdp_current = rtrim($arab_country_gdp_current, '0');
        $arab_country_gdp_current = rtrim($arab_country_gdp_current, '.');

        //GDP Per Capita
        $arab_country_gdp_per_capita = number_format($arab_country_gdp_per_capita, 2, '.', ',');
        // Remove the decimal part if it's .00
        $arab_country_gdp_per_capita = rtrim($arab_country_gdp_per_capita, '0');
        $arab_country_gdp_per_capita = rtrim($arab_country_gdp_per_capita, '.');

        //Area
        $arab_country_area_sq_kms = number_format($arab_country_area_sq_kms, 2, '.', ',');
        // Remove the decimal part if it's .00
        $arab_country_area_sq_kms = rtrim($arab_country_area_sq_kms, '0');
        $arab_country_area_sq_kms = rtrim($arab_country_area_sq_kms, '.');

        //Population
        $arab_country_population = number_format($arab_country_population, 2, '.', ',');
        // Remove the decimal part if it's .00
        $arab_country_population = rtrim($arab_country_population, '0');
        $arab_country_population = rtrim($arab_country_population, '.');

        //Access Health services
        $arab_country_access_health_services = number_format($arab_country_access_health_services, 2, '.', ',');
        // Remove the decimal part if it's .00
        $arab_country_access_health_services = rtrim($arab_country_access_health_services, '0');
        $arab_country_access_health_services = rtrim($arab_country_access_health_services, '.');

        //Access Safe Drinking
        $arab_country_access_safe_drinking_water = number_format($arab_country_access_safe_drinking_water, 2, '.', ',');
        // Remove the decimal part if it's .00
        $arab_country_access_safe_drinking_water = rtrim($arab_country_access_safe_drinking_water, '0');
        $arab_country_access_safe_drinking_water = rtrim($arab_country_access_safe_drinking_water, '.');

        //Country wise loan type and counts of project.
        $arab_countries_loans_data = arab_funds_display_data_country_project_type($current_country_id, 'loan');
        $arab_countries_grant_type_data = arab_funds_display_data_country_project_type($current_country_id, 'grant');
        $arab_countries_private_type_data = arab_funds_display_data_country_project_type($current_country_id, 'private');



        $get_all_available_sectors = arab_funds_get_all_sectors();
        $arab_current_year = $latest_macros['country_year'];
        //print_r($arab_current_year);
        if ($arab_current_year !== "Select Year") {
            $dateTime = new DateTime("$arab_current_year-01-01");
            $arab_previous_year = $dateTime->modify('-1 year')->format('Y');
            $arab_before_previous = $dateTime->modify('-1 year')->format('Y');
        }

        /*$other_sectors_project_data = arab_funds_get_projects_by_country_sector( $current_country_id , 'Other Sectors' );
        $telecomm_projects_data = arab_funds_get_projects_by_country_sector( $current_country_id , 'Telecomm' );
        $social_services_projects_data = arab_funds_get_projects_by_country_sector( $current_country_id , 'Social Services' );
        $industry_mining_projects_data = arab_funds_get_projects_by_country_sector( $current_country_id , 'Industry and Mining' );
        //$industry_mining_projects_data = array();
        $agriculture_projects_data     = arab_funds_get_projects_by_country_sector( $current_country_id , 'Agriculture' );
        $energy_projects_data     = arab_funds_get_projects_by_country_sector( $current_country_id , 'Energy' );
        $water_sewage_projects_data = arab_funds_get_projects_by_country_sector( $current_country_id , 'Water and Sewage' );
        $transport_projects_data = arab_funds_get_projects_by_country_sector( $current_country_id , 'Transport' );*/
        $country_listing = arab_funds_total_countries_display();
        //print_r($country_listing);

        if ($current_language === 'en-us') {
            $country_loans_url = get_site_url() . '/overview/list-of-all-projects?ptype=loan&cid=' . get_the_ID();
            $country_grants_url = get_site_url() . '/overview/list-of-all-projects?ptype=grant&cid=' . get_the_ID();
            $country_private_url = get_site_url() . '/overview/list-of-all-projects?ptype=private&cid=' . get_the_ID();
        } else {
            $country_loans_url = get_site_url() . '/' . $current_language . '/afesd-activities/list-of-all-projects?ptype=loan&cid=' . get_the_ID();
            $country_grants_url = get_site_url() . '/' . $current_language . '/afesd-activities/list-of-all-projects?ptype=grant&cid=' . get_the_ID();
            $country_private_url = get_site_url() . '/' . $current_language . '/afesd-activities/list-of-all-projects?ptype=private&cid=' . get_the_ID();
        }

        ?>
        <main class="main-content country-info">
            <div class="form-container">
                <div class="dropdown-list location-sort">
                    <img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-location.svg"; ?>" alt=""><?php if ($country_listing->have_posts()) { ?>
                        <select class="form-control order-by" name="country-change">
                            <?php while ($country_listing->have_posts()) {
                                $country_listing->the_post();
                                if (get_the_ID() == $current_country_id) { ?>
                                    <option selected value="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></option>

                                <?php } else { ?>
                                    <option value="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></option>
                                <?php }
                                ?>

                            <?php }
                            wp_reset_postdata(); ?>

                            <!-- <option disabled selected value=""> تغيير الدولة </option>
                    <option>Option-1</option>
                    <option>Option-2</option>
                    <option>Option-3 </option> -->
                        </select>
                    <?php } ?>
                </div>


            </div>
            <div class="d-flex second-row al-jazeera-bold">
                <div class="first-col">
                    <div class="first-col-row1">
                        <div class="country-info">
                            <div class="country-info-heading">
                                <p class="text-48 text-white"><?php echo get_the_title(); ?></p>
                            </div>
                            <div class="d-flex">
                                <div class="d-flex gap-10 w-50">
                                    <div class="country-info-img">
                                        <img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-group.svg"; ?>" alt="">
                                    </div>
                                    <div>
                                        <p class="text-18 text-white">
                                            <?php echo arabfund_plugin_str_display('Population (x1000)'); ?>
                                        </p>
                                        <p class="text-26 text-white"><?php echo $arab_country_population; ?></p>
                                    </div>
                                </div>
                                <div class="d-flex gap-10  w-50">
                                    <div class="country-info-img">
                                        <img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-navigator.svg"; ?>" alt="">
                                    </div>
                                    <div>
                                        <p class="text-18 text-white">
                                            <?php echo arabfund_plugin_str_display('Area (Square Km)'); ?>
                                        </p>
                                        <p class="text-26 text-white">
                                            <?php if ($arab_country_area_sq_kms === NULL || $arab_country_area_sq_kms == 0) {
                                                echo "-";
                                            } else {
                                                echo $arab_country_area_sq_kms;
                                            }
                                            ?>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="rectangle-flag-l">
                            <img src="<?php echo $country_image_url; ?>" alt="">
                        </div>
                    </div>
                    <div class="first-col-row2 group-tabs">

                        <div class="tab-titles">
                            <p class="tab-links active-link text-26" onclick="opentab('economic-indicators')">
                                <?php echo arabfund_plugin_str_display('Economic Indicators'); ?>
                            </p>
                            <p class="tab-links text-26" onclick="opentab('major-projects')">
                                <?php echo arabfund_plugin_str_display('Main projects of the sector'); ?>
                            </p>
                        </div>
                        <div class="tab-contents active-tab" id="economic-indicators" class="economic-indicators">
                            <div class="project-tables">
                                <table class="summary-table project-table">
                                    <tbody>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('GDP at Current Prices (Million $)'); ?>
                                            </td>
                                            <td class="td"><?php if ($arab_country_gdp_current === NULL || $arab_country_gdp_current == 0) {
                                                echo "-";
                                            } else {
                                                echo $arab_country_gdp_current;
                                            } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('GDP Per Capita ($)'); ?>
                                            </td>
                                            <td class="td"><?php if ($arab_country_gdp_per_capita === NULL || $arab_country_gdp_per_capita == 0) {
                                                echo "-";
                                            } else {
                                                echo $arab_country_gdp_per_capita;
                                            } ?></td>
                                        </tr>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('Real GDP Growth Rate (%)'); ?>
                                            </td>
                                            <td class="td">
                                                <?php if ($arab_country_real_gdp_growth === NULL || $arab_country_real_gdp_growth == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $arab_country_real_gdp_growth;
                                                } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('Inflation Rate (%)'); ?>
                                            </td>
                                            <td class="td">
                                                <?php if ($arab_country_inflation_rate === NULL || $arab_country_inflation_rate == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $arab_country_inflation_rate;
                                                } ?>
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>
                                <table class="summary-table project-table">
                                    <tbody>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('Agriculture Value Added (% of GDP)'); ?>
                                            </td>
                                            <td class="td">
                                                <?php if ($arab_country_ariculture_value_added === NULL || $arab_country_ariculture_value_added == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $arab_country_ariculture_value_added;
                                                } ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('Extractive Industries Value Added (% of GDP)'); ?>
                                            </td>
                                            <td class="td">
                                                <?php if ($arab_country_extractive_value_added === NULL || $arab_country_extractive_value_added == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $arab_country_extractive_value_added;
                                                } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('Manufacturing Industries Value Added (% of GDP)'); ?>
                                            </td>
                                            <td class="td">
                                                <?php if ($arab_country_manufacturing_value_added === NULL || $arab_country_manufacturing_value_added == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $arab_country_manufacturing_value_added;
                                                } ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('Service Sector Value Added (% of GDP)'); ?>
                                            </td>
                                            <td class="td">
                                                <?php if ($arab_country_service_sector_value_added === NULL || $arab_country_service_sector_value_added == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $arab_country_service_sector_value_added;
                                                } ?>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                                <table class="summary-table project-table">
                                    <tbody>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('Current Account Balance (% of GDP)'); ?>
                                            </td>
                                            <td class="td">
                                                <?php if ($arab_country_current_country_balance === NULL || $arab_country_current_country_balance == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $arab_country_current_country_balance;
                                                } ?>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="summary-table project-table">
                                    <tbody>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('% of Population with Access to Health Services'); ?>
                                            </td>
                                            <td class="td">
                                                <?php if ($arab_country_access_health_services === NULL || $arab_country_access_health_services == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $arab_country_access_health_services . "(٭٭)";
                                                } ?>


                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('% of Population with Access to Safe Drinking Water'); ?>
                                            </td>
                                            <td class="td">
                                                <?php if ($arab_country_access_safe_drinking_water === NULL || $arab_country_access_safe_drinking_water == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $arab_country_access_safe_drinking_water . "(٭٭)";
                                                } ?>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('% of Population with Suitable Sanitation Facilities'); ?>
                                            </td>
                                            <td class="td">
                                                <?php if ($arab_country_sanitation_facilities === NULL || $arab_country_sanitation_facilities == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $arab_country_sanitation_facilities . "(٭٭)";
                                                } ?>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="summary-table project-table">
                                    <tbody>
                                        <tr>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display('Labor Force (% of Population)'); ?>
                                            </td>
                                            <td class="td">
                                                <?php if ($arab_country_labor_force === NULL || $arab_country_labor_force == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $arab_country_labor_force . "(٭٭)";
                                                } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php if ($arab_current_year !== "Select Year") { ?>
                                    <?php if ($current_language == 'ar') { ?>
                                        <div class="text-21  text-gray resources">
                                            <div>
                                                <span>المصدر:</span>
                                                <span class="text-success al-jazeera-bold">التقرير الاقتصادي العربي
                                                    الموحد<?php echo "(" . ($arab_current_year + 1) . ")"; ?>,</span><span>جميع المؤشرات لعام <?php echo $arab_current_year; ?>, ماعدا
                                                </span>
                                            </div>
                                            <p>(٭) مؤشرات لعام <?php echo $arab_previous_year; ?>
                                            </p>
                                            <p>(٭٭) مؤشرات لعام <?php echo $arab_before_previous; ?> وماقبل</p>
                                        </div>
                                    <?php } else { ?>
                                        <div class="text-21  text-gray resources">
                                            <div>
                                                <span>Source:</span>
                                                <span class="text-success al-jazeera-bold">Arab Economic Report
                                                    Unified <?php echo "(" . ($arab_current_year + 1) . ")"; ?>,</span>
<span>All indicators for the year <?php echo $arab_current_year; ?>, except
                                                </span>
                                            </div>
                                            <p>(٭) Indicators for the year <?php echo $arab_previous_year; ?>
                                            </p>
                                            <p>(٭٭) Indicators for the year <?php echo $arab_before_previous; ?> And before</p>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-contents" id="major-projects">
                            <div>
                                <div class="accordion">
                                    <?php if (!empty($get_all_available_sectors) && is_array($get_all_available_sectors)) {
                                        foreach ($get_all_available_sectors as $key_sector => $sector_data) {

                                            $assigned_sector_data = arab_funds_get_projects_by_country_sector($current_country_id, trim($sector_data->post_title), array('loan', 'private'));
                                            $sector_icon = get_the_post_thumbnail_url($sector_data->ID, 'full');
                                            $sector_main_label = trim($sector_data->post_title) . " : " . get_the_title($current_country_id) . " " . arabfund_plugin_str_display('Project Status as of 12/31/2022');
                                            /*echo "<pre>";
                                                print_r($assigned_sector_data);
                                            echo "</pre>";*/
                                            ini_set('display_errors', 1);
                                            ini_set('display_startup_errors', 1);
                                            error_reporting(E_ALL);
                                            if (!empty($assigned_sector_data['available_projects']) && is_array($assigned_sector_data['available_projects'])) {
                                                ?>
                                                <div class="accordion-item">
                                                    <button class="accordion-button">
                                                        <div class="d-flex accordion-title">
                                                            <div class="accoudion-icon">
                                                                <img src="<?php echo $sector_icon; ?>" alt="">

                                                            </div>
                                                            <span class="text-26  "><?php echo trim($sector_data->post_title); ?></span>
                                                        </div>
                                                        <img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-arrow.svg"; ?>" alt=""
                                                            class="accordion-icon">
                                                    </button>
                                                    <div class="accordion-content">
                                                        <p class="accordion-conten-title text-22"><?php echo $sector_main_label; ?></p>
                                                        <table class="summary-table">
                                                            <thead>
                                                                <tr>
                                                                    <th class="th"><?php echo arabfund_plugin_str_display('the number'); ?>
                                                                    </th>
                                                                    <th class="th text-right">
                                                                        <?php echo arabfund_plugin_str_display('Loan number'); ?>
                                                                    </th>
                                                                    <th class="th"><?php echo arabfund_plugin_str_display('The Project'); ?>
                                                                    </th>
                                                                    <th class="th text-right">
                                                                        <?php echo arabfund_plugin_str_display('Sector'); ?>
                                                                    </th>
                                                                    <th class="th">
                                                                        <?php echo arabfund_plugin_str_display('General Approval'); ?>
                                                                    </th>
                                                                    <th class="th">
                                                                        <?php echo arabfund_plugin_str_display('Original Amount'); ?>
                                                                    </th>
                                                                    <th class="th">
                                                                        <?php echo arabfund_plugin_str_display('Amount cancelled'); ?>
                                                                    </th>
                                                                    <th class="th"><?php echo arabfund_plugin_str_display('Net amount'); ?>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($assigned_sector_data['available_projects'] as $key => $projects) {

                                                                    $project_loan_number = get_field('project_loan_number', $projects->ID);
                                                                    $project_approved_year = get_field('project_approved_year', $projects->ID);

                                                                    $project_orignal_amount = get_field('project_original_amount', $projects->ID);
                                                                    $project_cancelled_amount = get_field('project_cancelled_amount', $projects->ID);
                                                                    $project_net_amount = get_field('project_net_amount', $projects->ID);

                                                                    $project_orignal_amount = (floatval($project_orignal_amount) / 1000);
                                                                    $project_cancelled_amount = (floatval($project_cancelled_amount) / 1000);
                                                                    $project_net_amount = (floatval($project_net_amount) / 1000);

                                                                    $project_orignal_amount = number_format($project_orignal_amount, 2, '.', ',');
                                                                    // Remove the decimal part if it's .00
                                                                    $project_orignal_amount = rtrim($project_orignal_amount, '0');
                                                                    $project_orignal_amount = rtrim($project_orignal_amount, '.');

                                                                    $project_cancelled_amount = number_format($project_cancelled_amount, 2, '.', ',');
                                                                    // Remove the decimal part if it's .00
                                                                    $project_cancelled_amount = rtrim($project_cancelled_amount, '0');
                                                                    $project_cancelled_amount = rtrim($project_cancelled_amount, '.');

                                                                    $project_net_amount = number_format($project_net_amount, 2, '.', ',');
                                                                    // Remove the decimal part if it's .00
                                                                    $project_net_amount = rtrim($project_net_amount, '0');
                                                                    $project_net_amount = rtrim($project_net_amount, '.');

                                                                    ?>
                                                                    <tr>
                                                                        <td class="td"><?php echo ($key + 1); ?></td>
                                                                        <td class="td"><?php echo $project_loan_number; ?></td>
                                                                        <td class="td text-right project-name">
                                                                            <?php
                                                                            $current_language_post_id = pll_get_post($projects->ID);
                                                                            $current_language_post_url = get_permalink($current_language_post_id);
                                                                            $current_language_post_content = $projects->post_content;
                                                                            //echo $current_language_post_content;
                                                                            if ($current_language_post_content !== "") { ?>
                                                                                <a
                                                                                    href="<?php echo $current_language_post_url; ?>"><?php echo $projects->post_title; ?></a>
                                                                                <?php

                                                                            } else { ?>
                                                                                <?php echo $projects->post_title; ?>
                                                                            <?php }
                                                                            ?>

                                                                        </td>
                                                                        <td class="td text-right">
                                                                            <?php echo arabfund_plugin_str_display(trim($sector_data->post_title)); ?>
                                                                        </td>
                                                                        <td class="td"><?php echo $project_approved_year; ?></td>
                                                                        <td class="td"><?php echo $project_orignal_amount; ?></td>
                                                                        <td class="td"><?php echo $project_cancelled_amount; ?></td>
                                                                        <td class="td"><?php echo $project_net_amount; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th class="th"> </th>
                                                                    <th class="th text-right">
                                                                        <?php echo arabfund_plugin_str_display('the total'); ?>
                                                                    </th>
                                                                    <th class="th"> </th>
                                                                    <th class="th text-right"></th>
                                                                    <th class="th"> </th>
                                                                    <th class="th">
                                                                        <?php echo $assigned_sector_data['total_original_amount']; ?>
                                                                    </th>
                                                                    <th class="th">
                                                                        <?php echo $assigned_sector_data['total_cancelled_amount']; ?>
                                                                    </th>
                                                                    <th class="th"><?php echo $assigned_sector_data['total_net_amount']; ?>
                                                                    </th>

                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            <?php }
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="second-col">
                    <div class="summary-cards-vertical scrollable-tabs">
                        <div class="summary-card-vertical">
                            <div class="d-flex justify-content-between summary-card-vertical-heading">
                                <div class="d-flex">
                                    <img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-loan.svg"; ?>" alt=""
                                        class="flag-img">
                                    <a href="<?php echo $country_loans_url; ?>">
                                        <p class="text-24"><?php echo arabfund_plugin_str_display('TOTAL LOANS MADE'); ?></p>
                                </div>
                                <img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-arrow.svg"; ?>" alt=""
                                    class="arrow-img"></a>
                            </div>
                            <div class="d-flex justify-content-between align-items-center summary-card-vertical-body">
                                <div>
                                    <p class="card-subtitle"><?php echo arabfund_plugin_str_display('the number'); ?></p>
                                    <a href="<?php echo $country_loans_url; ?>">
                                        <p class="card-numbers"><?php echo $arab_countries_loans_data['projects_count']; ?></p>
                                    </a>
                                </div>
                                <div>
                                    <p class="card-subtitle"><?php echo arabfund_plugin_str_display('Amount (thousand KWD)'); ?>
                                    </p>
                                    <p class="card-numbers"><?php echo $arab_countries_loans_data['projects_amount']; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="summary-card-vertical">
                            <div class="d-flex justify-content-between summary-card-vertical-heading">
                                <div class="d-flex">
                                    <img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-money.svg"; ?>" alt=""
                                        class="flag-img">
                                    <a href="<?php echo $country_grants_url; ?>">
                                        <p class="text-24"><?php echo arabfund_plugin_str_display('Aid provided'); ?></p>
                                </div>
                                <img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-arrow.svg"; ?>" alt=""
                                    class="arrow-img"></a>
                            </div>
                            <div class="d-flex justify-content-between align-items-center summary-card-vertical-body">
                                <div>
                                    <p class="card-subtitle"><?php echo arabfund_plugin_str_display('the number'); ?></p>
                                    <a href="<?php echo $country_grants_url; ?>">
                                        <p class="card-numbers"><?php echo $arab_countries_grant_type_data['projects_count']; ?>
                                        </p>
                                    </a>
                                </div>
                                <div>
                                    <p class="card-subtitle"><?php echo arabfund_plugin_str_display('Amount (thousand KWD)'); ?>
                                    </p>
                                    <p class="card-numbers"><?php echo $arab_countries_grant_type_data['projects_amount']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="summary-card-vertical">
                            <div class="d-flex justify-content-between summary-card-vertical-heading">
                                <div class="d-flex">
                                    <img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-project-management.svg"; ?>" alt=""
                                        class="flag-img">
                                    <a href="<?php echo $country_private_url; ?>">
                                        <p class="text-24"><?php echo arabfund_plugin_str_display('PRIVATE SECTOR'); ?></p>
                                </div>
                                <img src="<?php echo ARAB_FUNDS_INC_URL . "/images/icon-arrow.svg"; ?>" alt=""
                                    class="arrow-img"></a>
                            </div>
                            <div class="d-flex justify-content-between align-items-center summary-card-vertical-body">
                                <div>
                                    <p class="card-subtitle"><?php echo arabfund_plugin_str_display('the number'); ?></p>
                                    <a href="<?php echo $country_private_url; ?>">
                                        <p class="card-numbers">
                                            <?php echo ($arab_countries_private_type_data['projects_count']); ?>
                                        </p>
                                    </a>
                                </div>
                                <div>
                                    <p class="card-subtitle"><?php echo arabfund_plugin_str_display('Amount (thousand KWD)'); ?>
                                    </p>
                                    <p class="card-numbers">
                                        <?php echo $arab_countries_private_type_data['projects_net_amount']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>



        </main>
        <?php
        return ob_get_clean();
    }

    /**

     * Shortcode displaying indivisual details of every country

     *

     * @package Arab Funds

     * @since 1.0.0

     */



    public function arab_funds_project_listing_details()
    {

        ob_start();
        $country_id = '';
        $project_type = '';
        if (!empty($_GET['ptype']) && !empty($_GET['cid'])) {
            $country_id = $_GET['cid'];
            $project_type = $_GET['ptype'];
        }

        $current_language = pll_current_language();
        $arab_country_projects_data = arab_funds_display_data_country_project_type($country_id, $project_type);
        //print_r($arab_country_projects_data['projects_count']);
        $totalPages = ceil($arab_country_projects_data['projects_count'] / 30);
        //echo $totalPages;
        $arab_funds_available_sectors = arab_funds_get_all_sectors();
        $arab_funds_available_years = arab_funds_get_available_years();
        $available_countries = arab_funds_get_countries($current_language);
        $country_image = get_the_post_thumbnail_url($country_id, 'full');
        $country_label_heading = '';
        if ($project_type == 'loan') {
            $country_label_heading = arabfund_plugin_str_display('Authorized Public Sector Loans');
        } else {
            $country_label_heading = arabfund_plugin_str_display('Extended Grants');
        }
        $country_label_heading .= " 31/12/2022 " . arabfund_plugin_str_display('as in') . " - " . get_the_title($country_id);
        $country_title_heading = arabfund_plugin_str_display('Country') . " : " . get_the_title($country_id);

        ?>

        <main class="main-content al-jazeera-bold">
            <div class="table-filter-tabs">
                <div class="form-container">
                    <div class="dropdown-list">
                        <label for="country"
                            class="text-24 "><?php echo arabfund_plugin_str_display('Please select the country'); ?> </label>
                        <select class="form-control order-by" id="arab-country-filter" class="filter-dropdown" name="country">
                            <option disabled selected value=""><?php echo arabfund_plugin_str_display('Country'); ?></option>
                            <?php if (!empty($available_countries)) {
                                foreach ($available_countries as $key => $country_data) {
                                    $isSelected = ($country_id == $country_data->ID) ? 'selected' : '';
                                    ?>
                                    <option value=<?php echo $country_data->ID ?>                 <?php echo $isSelected; ?>><?php echo $country_data->post_title; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="dropdown-list">
                        <label for="country"
                            class="text-24 "><?php echo arabfund_plugin_str_display('Please select the sector'); ?> </label>
                        <select class="form-control order-by" id="arab-sector-filter" class="filter-dropdown" name="country">
                            <option disabled selected value=""><?php echo arabfund_plugin_str_display('Sector'); ?></option>
                            <?php if (!empty($arab_funds_available_sectors)) {
                                foreach ($arab_funds_available_sectors as $key => $sector_data) {
                                    ?>
                                    <option value="<?php echo $sector_data->ID; ?>">
                                        <?php echo arabfund_plugin_str_display($sector_data->post_title); ?>
                                    </option>
                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="dropdown-list">
                        <label for="country"
                            class="text-24 "><?php echo arabfund_plugin_str_display('Please select a year'); ?></label>
                        <select class="form-control order-by" id="arab-year-filter" class="filter-dropdown" name="country">
                            <option disabled selected value=""><?php echo arabfund_plugin_str_display('Year'); ?></option>
                            <?php foreach ($arab_funds_available_years as $ykey => $year) { ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="radio-container">
                    <label class="radio-button">
                        <?php if (empty($_GET['ptype'])) { ?>
                            <input type="radio" name="arab-project-type" value="loan" <?php echo 'checked'; ?>>
                            <?php

                        } else { ?>
                            <input type="radio" name="arab-project-type" value="loan" <?php if (isset($_GET['ptype']) && $_GET['ptype'] == 'loan')
                                echo 'checked'; ?>>
                        <?php } ?>
                        <span class="radio"></span>
                        <?php echo arabfund_plugin_str_display('Loans'); ?>
                    </label>
                    <label class="radio-button">
                        <input type="radio" name="arab-project-type" value="grant" <?php if (isset($_GET['ptype']) && $_GET['ptype'] == 'grant')
                            echo 'checked'; ?>>
                        <span class="radio"></span>
                        <?php echo arabfund_plugin_str_display('Grants'); ?>
                    </label>
                    <label class="radio-button">
                        <input type="radio" name="arab-project-type" value="private">
                        <span class="radio"></span>
                        <?php echo arabfund_plugin_str_display('Private'); ?>
                    </label>
                    <label class="radio-button">
                        <input type="radio" name="arab-project-type" value="contribution">
                        <span class="radio"></span>
                        <?php echo arabfund_plugin_str_display('Contributions'); ?>
                    </label>
                </div>
                <div class="btn_sec">
                    <input type="button" value="<?php echo pll__("Reset") ?>" class="refresh reset-project-filters">
                    <input type="button" name="filter_projects" class="filter-btn filter-projects"
                        value="<?php echo pll__("Filter") ?>">
                </div>
            </div>
            <div class="section-sepertator"></div>
            <div id="loader">
                <img alt="Loading..." src="<?php echo get_stylesheet_directory_uri() . '/assets/images/arab-loader.svg'; ?>">
            </div>
            <div class="table projects-summary">
                <?php if (!empty($_GET['ptype']) && !empty($_GET['cid'])) { ?>
                    <div class="table-heading">
                        <div>
                            <span class="text-28"><?php echo $country_label_heading; ?></span>
                            <span class="text-28"><?php echo arabfund_plugin_str_display('(Amounts in thousand KD)'); ?></span>
                        </div>
                        <div class="county-info d-flex align-items-center">
                            <span class="text-28"><?php echo $country_title_heading; ?></span>
                            <div class="rectangle-flag">
                                <img src="<?php echo $country_image; ?>" alt="flag">
                            </div>
                        </div>
                    </div>
                    <div>
                        <table class="summary-table">
                            <thead>
                                <tr>
                                    <th class="th"><?php echo arabfund_plugin_str_display('the number'); ?></th>
                                    <th class="th text-right"><?php echo arabfund_plugin_str_display('Loan number'); ?></th>
                                    <th class="th"><?php echo arabfund_plugin_str_display('The Project'); ?></th>
                                    <th class="th text-right"><?php echo arabfund_plugin_str_display('Sector'); ?></th>
                                    <th class="th"><?php echo arabfund_plugin_str_display('General Approval'); ?></th>
                                    <th class="th"><?php echo arabfund_plugin_str_display('Original Amount'); ?></th>
                                    <th class="th"><?php echo arabfund_plugin_str_display('Amount cancelled'); ?></th>
                                    <th class="th"><?php echo arabfund_plugin_str_display('Net amount'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                if (!empty($arab_country_projects_data['projects_loan']) && is_array($arab_country_projects_data['projects_loan'])) {
                                    foreach ($arab_country_projects_data['projects_loan'] as $key => $project_data) {


                                        $project_loan_number = get_field('project_loan_number', $project_data->ID);
                                        $project_approved_year = get_field('project_approved_year', $project_data->ID);

                                        $project_orignal_amount = get_field('project_original_amount', $project_data->ID);
                                        $project_cancelled_amount = get_field('project_cancelled_amount', $project_data->ID);
                                        $project_net_amount = get_field('project_net_amount', $project_data->ID);
                                        $project_sector = get_field('project_sector', $project_data->ID);

                                        if ($project_cancelled_amount == "" || $project_cancelled_amount === 'NULL' || $project_cancelled_amount == null) {
                                            $project_cancelled_amount = 0.000;
                                        }
                                        if (is_numeric($project_orignal_amount) && is_numeric($project_cancelled_amount) && is_numeric($project_net_amount)) {

                                            $project_orignal_amount = ($project_orignal_amount / 1000);
                                            $project_cancelled_amount = ($project_cancelled_amount / 1000);
                                            $project_net_amount = ($project_net_amount / 1000);

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
                                        ?>
                                        <tr class="list-item">
                                            <td class="td"><?php echo ($key + 1); ?></td>
                                            <td class="td"><?php echo $project_loan_number; ?></td>
                                            <td class="td text-right project-name">
                                                <?php
                                                $current_language_post_id = pll_get_post($project_data->ID);
                                                $current_language_post_url = get_permalink($current_language_post_id);
                                                $current_language_post_content = $project_data->post_content;
                                                //echo $current_language_post_content;
                                                if ($current_language_post_content !== "") {
                                                    ?>
                                                    <a
                                                        href="<?php echo $current_language_post_url; ?>"><?php echo $project_data->post_title; ?></a>
                                                <?php } else {
                                                    echo $project_data->post_title;
                                                }
                                                ?>

                                            </td>
                                            <td class="td text-right">
                                                <?php echo arabfund_plugin_str_display(get_the_title($project_sector)); ?>
                                            </td>
                                            <td class="td"><?php echo $project_approved_year; ?></td>
                                            <td class="td"><?php echo $project_orignal_amount; ?></td>
                                            <td class="td">
                                                <?php if ($project_cancelled_amount === 'NULL' || $project_cancelled_amount == null || $project_cancelled_amount == 0) {
                                                    echo "-";
                                                } else {
                                                    echo $project_cancelled_amount;
                                                } ?>
                                            </td>
                                            <td class="td"><?php echo $project_net_amount; ?></td>
                                        </tr>
                                    <?php }
                                } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="th"> </th>
                                    <th class="th text-right"><?php echo arabfund_plugin_str_display('the total'); ?></th>
                                    <th class="th"> </th>
                                    <th class="th text-right"></th>
                                    <th class="th"> </th>
                                    <th class="th"><?php echo $arab_country_projects_data['projects_amount']; ?></th>
                                    <th class="th"><?php echo $arab_country_projects_data['projects_cancelled_amount']; ?></th>
                                    <th class="th"><?php echo $arab_country_projects_data['projects_net_amount']; ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="pagination-container"></div>
                <?php } ?>
            </div>
        </main>

        <?php

        return ob_get_clean();

    }


    /**

    * Shortcode displaying indivisual details of every project

    *

    * @package Arab Funds

    * @since 1.0.0

    */

    public function arab_funds_project_single_detail()
    {

        ob_start();

        $arab_project_loan_number = get_field('project_loan_number', get_the_ID());
        $project_int_rate = get_field('project_interest_rate', get_the_ID());
        $project_beneficiary = get_field('project_beneficiary', get_the_ID());
        $project_grace = get_field('project_grace_period', get_the_ID());
        $project_cost = get_field('project_cost', get_the_ID());
        $project_maturity = get_field('project_maturity', get_the_ID());
        $project_repayment = get_field('project_repayment', get_the_ID());
        $project_approval_date = get_field('project_board_approval_date', get_the_ID());
        $project_first_install = get_field('project_first_installment', get_the_ID());
        $project_original_amount = get_field('project_original_amount', get_the_ID());
        $project_data = get_post(get_the_id());
        $project_amount_of_loan = round($project_original_amount / 1000000, 1);
        // Use number_format to ensure one digit after the decimal point
        $formatted_project_amount = number_format($project_amount_of_loan, 1);
        $project_primary_caption = get_field('project_primary_caption', get_the_ID());
        $project_secondary_caption = get_field('project_secondary_caption', get_the_ID());
        $project_date_effectiveness = get_field('project_date_effectiveness', get_the_ID());
        $project_sign_date = get_field('project_sign_date', get_the_ID());
        $current_language = pll_current_language();


        ?>

        <div class="main-content project-info">
            <div class="page_project_details">
                <div class="heading-caption">
                    <?php if (!empty($project_primary_caption)) { ?>
                        <div class="elementor-widget-container">
                            <h2><?php echo $project_primary_caption; ?></h2>
                        </div>
                    <?php } ?>
                </div>
                <div class="elementor-element elementor-element-41836506 elementor-widget elementor-widget-shortcode">
                    <?php if (!empty($project_secondary_caption)) { ?>
                        <div class="elementor-widget-container">
                            <div class="elementor-shortcode"><span><?php echo $project_secondary_caption; ?></span></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="control-tabel">
                <table class="summary-table vertical-table">
                    <tbody>
                        <tr>
                            <!-- <?php if (!empty($arab_project_loan_number)) { ?>                                   
                                <td class="td text-right th"><?php echo arabfund_plugin_str_display('Loan No') . ":"; ?></td>
                                <td class="td"><?php echo $arab_project_loan_number; ?></td>
                            <?php }
                            if (!empty($project_int_rate)) { ?>
                                <td class="td th"><?php echo arabfund_plugin_str_display('Interest Rate') . ":"; ?></td>
                                <td class="td"><?php echo $project_int_rate . " %  "; ?></td>    
                            <?php } ?>    -->
                            <td class="td text-right th"><?php echo arabfund_plugin_str_display('Loan No') . ":"; ?></td>
                            <td class="td"><?php echo !empty($arab_project_loan_number) ? $arab_project_loan_number : '-'; ?>
                            </td>
                            <td class="td th"><?php echo arabfund_plugin_str_display('Interest Rate') . ":"; ?></td>
                            <td class="td"><?php echo !empty($project_int_rate) ? $project_int_rate . " %" : '-'; ?></td>
                        </tr>
                        <tr>
                            <?php if (!empty($project_beneficiary)) { ?>
                                <td class="td text-right th"><?php echo arabfund_plugin_str_display('Beneficiary') . ":"; ?></td>
                                <td class="td"><?php echo $project_beneficiary; ?></td>
                            <?php }
                            if (!empty($project_grace)) { ?>
                                <td class="td th"><?php echo arabfund_plugin_str_display('Grace Period') . ":"; ?></td>
                                <td class="td">
                                    <?php if ($current_language === 'ar') {
                                        if ($project_grace == 1) {
                                            echo $project_grace . " سنة";
                                        } else if ($project_grace == 2) {
                                            echo $project_grace . " سنتان";
                                        } else if ($project_grace >= 3 && $project_grace <= 10) {
                                            echo $project_grace . " سنوات";
                                        } else if ($project_grace >= 11 && $project_grace <= 99) {
                                            echo $project_grace . " سنةً";
                                        } else if ($project_grace >= 100 && $project_grace <= 1000) {
                                            echo $project_grace . " سنةٍ";
                                        }
                                    } else { ?>
                                        <?php echo $project_grace . " " . arabfund_plugin_str_display('years'); ?>
                                    <?php } ?>
                                </td>
                                <!-- From 3 to 10 we use ٍسنوات
                                        From 11 to 99 we use سنةً
                                with 100 and 1000 we سنةٍ 
                            just in case there is one or two, 
1 سنة
2 سنتان-->
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if (!empty($project_cost)) { ?>
                                <td class="td text-right th"><?php echo arabfund_plugin_str_display('Project Cost') . ":"; ?></td>
                                <td class="td"><?php echo $project_cost; ?></td>
                            <?php }
                            if (!empty($project_maturity)) { ?>
                                <td class="td th"><?php echo arabfund_plugin_str_display('Maturity') . ":"; ?></td>
                                <td class="td">
                                    <?php if ($current_language === 'ar') {
                                        if ($project_maturity == 1) {
                                            echo $project_maturity . " سنة";
                                        } else if ($project_maturity == 2) {
                                            echo $project_maturity . " سنتان";
                                        } else if ($project_maturity >= 3 && $project_maturity <= 10) {
                                            echo $project_maturity . " سنوات";
                                        } else if ($project_maturity >= 11 && $project_maturity <= 99) {
                                            echo $project_maturity . " سنةً";
                                        } else if ($project_maturity >= 100 && $project_maturity <= 1000) {
                                            echo $project_maturity . " سنةٍ";
                                        }
                                    } else { ?>
                                        <?php echo $project_maturity . " " . arabfund_plugin_str_display('years'); ?>
                                    <?php } ?>

                                </td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <?php if (!empty($formatted_project_amount)) { ?>
                                <td class="td text-right th"><?php echo arabfund_plugin_str_display('Amount of Loan') . ":"; ?></td>
                                <td class="td">
                                    <?php if ($current_language === 'ar') {
                                        echo $formatted_project_amount . " " . arabfund_plugin_str_display('million') . " د.ك";
                                    } else {
                                        echo "KD " . $formatted_project_amount . " " . arabfund_plugin_str_display('million');
                                    } ?>
                                </td>
                            <?php }
                            if (!empty($project_repayment)) { ?>
                                <td class="td th"><?php echo arabfund_plugin_str_display('Repayment') . ":"; ?></td>
                                <td class="td"><?php echo $project_repayment; ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <!-- <?php if (!empty($project_approval_date)) { ?>
                                <td class="td text-right th"><?php echo arabfund_plugin_str_display('Date of Board Approval') . ":"; ?></td>
                                <td class="td"><?php echo $project_approval_date; ?></td>
                            <?php }
                            if (!empty($project_first_install)) { ?>
                                <td class="td th"><?php echo arabfund_plugin_str_display('First Installment') . ":"; ?></td>
                                <td class="td"><?php echo $project_first_install; ?></td>    
                            <?php } ?>   -->
                            <td class="td text-right th">
                                <?php echo arabfund_plugin_str_display('Date of Board Approval') . ":"; ?>
                            </td>
                            <td class="td"><?php echo !empty($project_approval_date) ? $project_approval_date : '-'; ?></td>
                            <td class="td th"><?php echo arabfund_plugin_str_display('First Installment') . ":"; ?></td>
                            <td class="td"><?php echo !empty($project_first_install) ? $project_first_install : '-'; ?></td>
                        </tr>
                        <tr>
                            <!-- <?php if (!empty($project_sign_date)) { ?>
                                <td class="td text-right th"><?php echo arabfund_plugin_str_display('Date of Loan Agreement') . ":"; ?></td>
                                <td class="td"><?php echo $project_sign_date; ?></td>
                                <?php } ?>
                               
                                <?php if (!empty($project_date_effectiveness)) { ?>
                                <td class="td text-right th"><?php echo arabfund_plugin_str_display('Date of Loan Effectiveness') . ":"; ?></td>
                                <td class="td"><?php echo $project_date_effectiveness; ?></td>
                                <?php } ?> -->
                            <td class="td text-right th">
                                <?php echo arabfund_plugin_str_display('Date of Loan Agreement') . ":"; ?>
                            </td>
                            <td class="td"><?php echo !empty($project_sign_date) ? $project_sign_date : '-'; ?></td>
                            <td class="td text-right th">
                                <?php echo arabfund_plugin_str_display('Date of Loan Effectiveness') . ":"; ?>
                            </td>
                            <td class="td">
                                <?php echo !empty($project_date_effectiveness) ? $project_date_effectiveness : '-'; ?>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="project-info">
                <?php echo apply_filters('the_content', $project_data->post_content); ?>
                <!--<div class="mb-30">
                    <h2 class="secondary-title"> Objectives:
                    </h2>
                    <p class="description mt-10">
                        The project aims at eliminating the environmental problems resulting from the use of septic tanks by
                        inhabitants of the
                        villages in the Al Junaid area in Ajloun governorate and a number of villages north of Jerash
                        governorate, through the
                        construction of the necessary wastewater facilities, with capacities to meet the population increase
                        and the growing
                        urbanization of these villages up to 2045. The project will contribute to the improvement of the
                        health and
                        environmental conditions of the inhabitants, and will allow for protection from pollution of the
                        springs and
                        groundwater, which are currently used to supply most areas of Ajloun governorate with drinking
                        water. The project will
                        also allow for the use of treated wastewater for restricted agriculture in the vicinity of the
                        treatment plant.
                    </p>
                </div>
                <div class="mb-30">
                    <h2 class="secondary-title"> Description:
                    </h2>
                    <p class="description mt-10">
                        The project, which is expected to be completed by the end of 2024, comprises the construction of
                        main, secondary and
                        branch pipelines, including manholes and household connections, as well as the construction of water
                        pumping stations,
                        and a plant to treat wastewater and allow its reuse for agriculture. The project also comprises the
                        provision of the
                        necessary technical services to prepare the studies, detailed designs and tender documents, and work
                        supervision. The
                        project includes the following main components:
                    </p>
                    <ul class="description-list">
                        <li class="elementor-icon-list-item">
                            <span class="font-bold">
                                Construction of Wastewater Facilities: </span>
                            <span>
                                This includes the construction of networks to collect and transport the wastewater from the
                                villages of Ras Munif,
                                Sakhra, Ebbin, Ebillin, Kufr Khall and Balila. The networks comprise main, secondary and
                                branch pipelines with a total
                                length of about 200 km, and diameters ranging between about 150 and 500 mm, including
                                manholes and household
                                connections. This also includes the construction of a wastewater pumping station in Ras
                                Munif with a capacity of about
                                25 m3/hour and a head of about 70 m, through a pipeline with a length of about 1.4 km and a
                                diameter of about 100 mm.
                                This component also includes the construction of a wastewater treatment plant, next to the
                                existing Wadi Hassan plant,
                                with a capacity of about 10 thousand m3/day, supplied by the wastewater collected from a
                                pumping station with a capacity
                                of about 720 m3/hour and a head of about 50 m, through a pipeline with a length of about 2.2
                                km and a diameter of about
                                400 mm. The works of the treatment plant include the installation of filters for the
                                collection of floating solid
                                material, sedimentation tanks, sand filters and treated water disinfection facilities, in
                                addition to sludge drying
                                facilities. The pumping stations and treatment plant works include all the civil,
                                mechanical, hydromechanical and
                                electrical works, and the control and operating systems. </span>
                        </li>
                        <li class="elementor-icon-list-item">
                            <span class="font-bold">
                                Technical Services: </span>
                            <span>
                                This component includes the necessary consultancy services to prepare the project’s studies,
                                designs and tender
                                documents, and assist in the tendering process and bid evaluation, as well as supervision of
                                the project’s
                                implementation, and the conduct of any additional studies necessary to achieve the project’s
                                goals. </span>
                        </li>
                    </ul>
                </div>
                <div class="mb-30">
                    <h2 class="secondary-title">Financing: </h2>
                    <p class="description mt-10">
                        The two Arab Fund loans, the first No. 674/2020 and the supplementary, cover about 100% of the total
                        project cost. The
                        Jordanian government will cover the remaining cost of the project and any additional project cost
                        that may arise.
                    </p>
                </div>-->
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**

     * Shortcode displaying indivisual details of every project

     *

     * @package Arab Funds

     * @since 1.0.0

     */

    public function arab_traing_module_listing_display($atts)
    {

        ob_start();
        $current_site_id = get_current_blog_id();
        switch_to_blog(3);
        $current_language = pll_current_language();

        $component_query = array(
            'lang' => $current_language,
            array(
                'key' => 'choose_training_program',       // Meta key for project_type
                'value' => get_the_ID(),             // Meta value to match
                'compare' => '=',               // Comparison operator (optional, default is '=')
            )
            // Add more meta queries as needed    
        );
        $args = array(
            'numberposts' => -1,
            'post_type' => 'topics',           // Your custom post type name
            'post_status' => 'publish',          // Post status
            'meta_query' => $component_query,
        );
        $training_topics = get_posts($args);
        $assinged_comp = array();



        if (!empty($training_topics) && is_array($training_topics)) {
            foreach ($training_topics as $key => $training_component) {
                $assined_training_component = get_field('choose_training_component_2', $training_component->ID);
                array_push($assinged_comp, $assined_training_component);
            }
        }

        $assinged_comp = array_unique(call_user_func_array('array_merge', $assinged_comp));

        /*$training = array(
            'taxonomy' => 'training-component',
            'hide_empty' => false, // Set to true if you want to exclude terms with no posts
        );
        $training_sections = get_terms($training);*/
        $section_content_keys = array();
        ?>
        <main id="content" class="main-content country-info">
            <div class="container">
                <?php if (!empty($assinged_comp) && is_array($assinged_comp)) { ?>
                    <ul class="tabs topic-wrap">
                        <?php if ($current_language == 'ar') {
                            $assinged_comp = array_reverse($assinged_comp);
                        }
                        foreach ($assinged_comp as $key => $section) {
                            $section_content_keys[] = "tab-" . $section;
                            $section_data = get_term_by('id', $section, 'training-component');
                            if ($current_language == "ar") {
                                $arab_label = get_field('training_section_label', $section_data);
                                ?>
                                <li class="tab-link <?php echo ($key === 0) ? 'current' : ''; ?>"
                                    data-training-id="<?php echo get_the_ID(); ?>" data-tab="tab-<?php echo $section; ?>">
                                    <?php echo $arab_label; ?>
                                </li>
                                <?php

                            } else { ?>
                                <li class="tab-link <?php echo ($key === 0) ? 'current' : ''; ?>"
                                    data-training-id="<?php echo get_the_ID(); ?>" data-tab="tab-<?php echo $section; ?>">
                                    <?php echo $section_data->name; ?>
                                </li>

                            <?php }
                            ?>

                        <?php } ?>
                    </ul>
                <?php }
                foreach ($section_content_keys as $section_key => $section_data) { ?>
                    <div id="<?php echo $section_data; ?>"
                        class="tab-content training_sec_box <?php echo ($section_key === 0) ? 'current' : ''; ?>">
                        <?php if ($section_key === 0) {

                            $section_details = !empty($section_data) ? explode("-", $section_data) : '';
                            $current_language = pll_current_language();
                            $trainings = arab_funds_get_trainings_by_section($current_language, $section_details[1], get_the_ID());


                            ?>
                            <?php if (!empty($trainings) && is_array($trainings)) { ?>
                                <div class="events_container listed-topics-wrap">
                                    <?php foreach ($trainings as $key => $training_data) {
                                        $traing_file_data = get_field('topic_file', $training_data->ID);
                                        $media_type = get_field('source_type', $training_data->ID);

                                        $trainingImg = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                        if ($trainingImg == "") {
                                            if ($traing_file_data['type'] == 'video')
                                                $trainingImg = "/wp-content/uploads/2023/11/news_img.jpg";
                                            else
                                                $trainingImg = "/wp-content/themes/hello-elementor-child/assets/images/noimg_logo.jpg";
                                        }

                                        if ($media_type == 'file') {
                                            if ($traing_file_data['type'] == 'video') { ?>
                                                <div class="event_box">
                                                    <?php if (!empty($traing_file_data['url'])) { ?>
                                                        <div class="event_image training-item" data-video-path="<?php echo $traing_file_data['url']; ?>">
                                                            <img src="<?php echo $trainingImg ?>" alt="<?php echo $training_data->post_title; ?>">
                                                        </div>
                                                    <?php } ?>
                                                    <div class="program_card">
                                                        <?php echo $training_data->post_title; ?>
                                                    </div>
                                                </div>
                                                <?php

                                            } else if ($traing_file_data['type'] == 'application') { ?>
                                                    <div class="event_box">
                                                    <?php if (!empty($traing_file_data['url'])) { ?>
                                                            <div class="event_image">
                                                                <a href="<?php echo $traing_file_data['url']; ?>" target="_blank">
                                                                    <img src="<?php echo $trainingImg ?>" alt="<?php echo $training_data->post_title; ?>">
                                                                </a>
                                                            </div>
                                                    <?php } ?>
                                                        <div class="program_card">
                                                            <a href="<?php echo $traing_file_data['url']; ?>"
                                                                target="_blank"><?php echo $training_data->post_title; ?></a>
                                                        </div>
                                                    </div>

                                            <?php }
                                        } else {
                                            $video_url = get_field('video_url', $training_data->ID);
                                            ?>
                                            <div class="event_box">
                                                <?php if (!empty($video_url)) { ?>
                                                    <a class="event_image training-item-youtube" href="<?php echo $video_url; ?>">
                                                        <img src="<?php echo $trainingImg ?>" alt="<?php echo $training_data->post_title; ?>">
                                                    </a>
                                                <?php } ?>
                                                <div class="program_card">
                                                    <?php echo $training_data->post_title; ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } ?>
                                    <!-- <div id="event-pagination"></div>    -->
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
                        ?>
                    </div>
                <?php } ?>
            </div>
        </main>
        <?php
        restore_current_blog();
        return ob_get_clean();
    }

    /**

     * Shortcode displaying list for contribution to captial

     *

     * @package Arab Funds

     * @since 1.0.0

     */

    public function arab_list_contribution_to_capital()
    {
        ob_start();
        $current_language = pll_current_language();
        $contri_primary_heading = get_field('project_summary_heading_primary', get_the_ID());
        $contri_primary_secondary = get_field('project_summary_heading_secondary', get_the_ID());


        $contri_cap_query = array(
            'relation' => 'AND',
            'lang' => $current_language,
            array(
                'key' => 'project_type',       // Meta key for project_type
                'value' => 'private',             // Meta value to match
                'compare' => '=',               // Comparison operator (optional, default is '=')
            ),
            array(
                'key' => 'project_is_contribution_capital',    // Meta key for project_country
                'value' => 1, // Replace 'your_country_value' with the actual value to match
                'compare' => '=',               // Comparison operator (optional, default is '=')
            )
            // Add more meta queries as needed    
        );
        $args = array(
            'numberposts' => -1,
            'post_type' => 'projects',           // Your custom post type name
            'post_status' => 'publish',          // Post status
            'meta_query' => $contri_cap_query,
            //'order' => 'ASC',
            'orderby' => 'meta_value_num',       // Order by numeric value of meta field
            'meta_key' => 'project_start_date',     // Meta key to order by
            'order' => 'DESC',
        );
        // print_r($args);
        $contri_cap_projects = get_posts($args);


        ?>
        <div class="elementor-element elementor-element-58bfa11 text-gray elementor-widget elementor-widget-heading">
            <div class="elementor-widget-container">
                <?php if (!empty($contri_primary_heading)) { ?>
                    <h4 class="elementor-heading-title elementor-size-default"><?php echo $contri_primary_heading; ?></h4>
                <?php }
                if (!empty($contri_primary_heading)) { ?>
                    <p class="elementor-heading-title elementor-size-default"><?php echo $contri_primary_secondary; ?></p>
                <?php } ?>
            </div>
        </div>
        <div class="ea-advanced-data-table-wrap sc">
            <div class="ea-advanced-data-table-wrap-inner">
                <table class="ea-advanced-data-table ea-advanced-data-table-static ea-advanced-data-table-4977884"
                    data-id="4977884">
                    <thead>
                        <tr>
                            <th>
                            </th>
                            <th>
                                <?php echo arabfund_plugin_str_display('Start Date'); ?>
                            </th>
                            <th>
                                <?php echo arabfund_plugin_str_display('Country'); ?>
                            </th>
                            <th>
                                <?php echo arabfund_plugin_str_display('Project'); ?>
                            </th>
                            <th>
                                <?php echo arabfund_plugin_str_display('Amount Paid (KD)'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($contri_cap_projects) && is_array($contri_cap_projects)) {

                            $total_amount_paid = 0;
                            foreach ($contri_cap_projects as $key => $pro_data) {
                                $sr_no = ($key + 1);
                                $project_country = get_field('project_country', $pro_data->ID);
                                $project_amout_paid = get_field('project_amount_paid', $pro_data->ID);
                                $total_amount_paid += $project_amout_paid;
                                $project_amout_paid = number_format($project_amout_paid, 2, '.', ',');
                                $project_amout_paid = rtrim($project_amout_paid, '0');
                                $project_amout_paid = rtrim($project_amout_paid, '.');
                                $project_start_date = get_field('project_start_date', $pro_data->ID);

                                ?>

                                <tr>
                                    <td>
                                        <?php echo $sr_no; ?>
                                    </td>
                                    <td>
                                        <?php echo $project_start_date; ?>
                                    </td>
                                    <td>
                                        <?php echo $project_country->post_title; ?>
                                    </td>
                                    <td>
                                        <?php echo $pro_data->post_title; ?>
                                    </td>
                                    <td>
                                        <?php echo $project_amout_paid; ?>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                        <tr>
                            <td></td>
                            <td>
                                <p><strong><?php echo arabfund_plugin_str_display('Total'); ?></strong></p>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <?php
                                $total_amount_paid = number_format($total_amount_paid, 2, '.', ',');
                                $total_amount_paid = rtrim($total_amount_paid, '0');
                                $total_amount_paid = rtrim($total_amount_paid, '.');
                                ?>
                                <p><strong><?php echo $total_amount_paid; ?></strong></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**

     * Shortcode method to display custom html in footer.

     *

     * @package Arab Funds

     * @since 1.0.0

     */

    public function arab_funds_footer_code()
    {
        ?>
        <!-- Popup itself -->
        <!-- <div id="search-form" class="full-popup mfp-hide">
            <p><?php echo get_search_form(); ?><p>
        </div> -->
        <?php

    }

    /**
     * Adding Hooks
     *
     * @package Arab Funds
     * @since 1.0.0
     */
    public function add_hooks()
    {
        add_shortcode('arab_funds_projecs_summary', array($this, 'arab_funds_projects_summary_data'));
        add_shortcode('arab_funds_country_summary', array($this, 'arab_funds_countries_listing_data'));
        add_shortcode('arab_funds_country_details', array($this, 'arab_funds_country_all_single_details'));
        add_shortcode('arab_funds_project_listing_details', array($this, 'arab_funds_project_listing_details'));
        add_shortcode('arab_funds_project_single_details', array($this, 'arab_funds_project_single_detail'));
        add_shortcode('arab_funds_training', array($this, 'arab_traing_module_listing_display'));
        add_shortcode('arab_funds_contribution_captital', array($this, 'arab_list_contribution_to_capital'));
        add_action('wp_footer', array($this, 'arab_funds_footer_code'));
    }
}


?>