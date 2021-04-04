<?php

/*
Plugin Name: Mortgage Calculator
Plugin URI: https://mortgage-magic.co.uk/
Description: This is a Mortgage Calculator for Mortgage Magic Clients
Version: 1.0
Author: Sagar Roy
Author URI: https://www.linkedin.com/in/sagar-roy-3445b5119/
Text Domian: mortgage
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

//Define Paths

define("PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
define("PLUGIN_URL", plugins_url());

//Assets For Output

function morgage_custom_assets(){
    
    //Bootstrap
    
    wp_enqueue_style(
        "mortgage_bootstrap",
        "//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
    );
    
    // Range Slider Css

    wp_enqueue_style(
        "mortgage_slider_css",
        PLUGIN_URL."/mortgage-calc/assets/css/rSlider.min.css", 
        "mortgage_bootstrap"
    );
    
    // Main CSs

    wp_enqueue_style(
        "mortgage_style",
        PLUGIN_URL."/mortgage-calc/style.css",
        "[mortgage_bootstrap, mortgage_slider_css]"
    );
    
    // responsive Css

    wp_enqueue_style(
        "mortgage_calc_responsive_style",
        PLUGIN_URL."/mortgage-calc/calc-responsive.css" , 
        "[mortgage_bootstrap, mortgage_slider_css, mortgage_style]"
    );

    // Jquery

    
    wp_enqueue_script(
        "mortgage-jquery",
        PLUGIN_URL."/mortgage-calc/assets/js/jquery-3.6.0.js", 
        "",
        null,
        true
        
    );

    //custom coded jquery

    wp_enqueue_script(
        "mortgage-calc-custom-jquery",
        PLUGIN_URL."/mortgage-calc/mortgage-jquery.js", 
        "mortgage-jquery",
        null,
        true
        
    );

    //Slider js

    wp_enqueue_script(
        "mortgage-slider-js",
        PLUGIN_URL."/mortgage-calc/assets/js/rSlider.min.js", 
        "",
        null,
        true
        
    );

    // Calculator JS

    wp_enqueue_script(
        "mortgage-calculator",
        PLUGIN_URL."/mortgage-calc/calculator.js", 
        "mortgage-slider-js",
        null,
        true
        
    );

    wp_enqueue_script(
        "mortgage-calc-js",
        PLUGIN_URL."/mortgage-calc/mortgage.js", 
        "[mortgage-jquery,mortgage-calc-custom-jquery]",
        null,
        true
        
    );
}


add_action("wp_enqueue_scripts" , "morgage_custom_assets");












// Register Admin Page for Plugin

function mortgage_custom_menu()
{
    add_menu_page(
        "mortgagecalc",  // Page title
        "Mortgage Calculator", // menu title
        "manage_options", // admin level
        "mortgage-calculator", // slug
        "mortgage_admin_view" // output function
    );
}

add_action("admin_menu", "mortgage_custom_menu");

function mortgage_admin_view()
{
    include_once PLUGIN_DIR_PATH."/admin-view/admin-panel-output.php";
}













//adding styles  worpress admin

if(!function_exists("mortgage_calc_admin_assests")) :
	function mortgage_calc_admin_assests() {
		global $pagenow;

		$current_page = get_current_screen();

		if( 
            (isset($_GET["page"]) && $_GET["page"] === 'mortgage-calculator')
		) { 
			wp_enqueue_style(
                "mortgage_bootstrap",
                "//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css", 
            );
		}

	}
    
//end of adding styles and scripts for wordpress admin.

add_action('admin_enqueue_scripts', 'mortgage_calc_admin_assests', 1);

endif;











// Create Shortcodes

add_shortcode('buy_to_let', "mortgage_buy_to_let_shortcode");

function mortgage_buy_to_let_shortcode(){
    ob_start();
    include_once PLUGIN_DIR_PATH."/tamplets/buy-to-let.php";
    return ob_get_clean();
}

add_shortcode('mortgage', "mortgage_calc_shortcode");

function mortgage_calc_shortcode(){
    ob_start();
    include_once PLUGIN_DIR_PATH."/tamplets/mortgage.php";
    return ob_get_clean();
}



   










