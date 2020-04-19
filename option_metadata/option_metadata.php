<?php
/*
Plugin Name: Option Meta Data
Plugin URI: 
Description: 
Author: Mohd Alam
Version: 1.7.2
Author URI: 
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