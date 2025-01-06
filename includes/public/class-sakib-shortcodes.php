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



class Sakib_Shortcodes

{



    public $scripts;



    //class constructor

    public function __construct()

    {



        global $arab_funds_scripts;



        $this->scripts = $arab_funds_scripts;

    }





    



    /**

     * Adding Hooks

     *

     * @package Arab Funds

     * @since 1.0.0

     */

    public function add_hooks()

    {

        //add_shortcode('arab_funds_project_single_details', array($this, 'arab_funds_project_single_details'));

    }

}

?>