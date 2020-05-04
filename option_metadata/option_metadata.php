<?php
/*
Plugin Name: Option Meta Data
Plugin URI: https://github.com/mohdalam392/WP_List_Table-of-wp_options-wordpress-table
Description: Option Meta Data List (Insert,Update,Delete)
Author: Mohd Alam
Version: 1.0
Author URI: http://www.facebook.com/alamdeveloper
*/

?>
<?php 
add_action('init',function(){

	/** Options Meta Deta **/
	require_once('includes/options/class-optionsmetadata-menu.php');
	require_once('includes/options/class-Option-list-table.php');
	require_once('includes/options/class-form-handler.php');	
	require_once('includes/options/Option-functions.php');
	new OptionsMetaData_Menu();
	/** Options Meta Deta **/
});
