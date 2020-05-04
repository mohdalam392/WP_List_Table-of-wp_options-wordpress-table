<?php

/**
 * Admin Menu
 */
class OptionsMetaData_Menu {

    /**
     * Kick-in the class
     */
    public function __construct() {
        global $current_user;

        // check captability
        if($current_user->roles[0]=='administrator'){
            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        }
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

        /** Top Menu **/
        add_menu_page( __( 'Meta Data', '' ), __( 'Options Meta Data', '' ), 'manage_options', 'metadata', array( $this, 'plugin_page' ), 'dashicons-groups', null );

       /* add_submenu_page( 'metadata', __( 'Options Meta Deta', '' ), __( 'Options Meta Deta', '' ), 'manage_options', 'optionsmetadata', array( $this, 'plugin_page' ) );*/
    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $option_id     = isset( $_GET['option_id'] ) ? intval( $_GET['option_id'] ) : 0;

        switch ($action) {
            case 'view':

                $template = dirname( __FILE__ ) . '/views/optionsmeta-single.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/optionsmeta-edit.php';
                break;

            case 'new':
                $template = dirname( __FILE__ ) . '/views/optionsmeta-new.php';
                break;

            case 'delete':
                $template = dirname( __FILE__ ) . '/views/optionsmeta-delete.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/optionsmeta-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}