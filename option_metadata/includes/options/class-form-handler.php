<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the option new and edit form
     *
     * @return void
     */
    public function handle_form() {

        if ( ! isset( $_POST['Submit_Option'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], '' ) ) {
            die( __( 'Are you cheating?', '' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', '' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=optionsmetadata' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $option_id = isset( $_POST['option_id'] ) ? sanitize_text_field( $_POST['option_id'] ) : '';
        $option_name = isset( $_POST['option_name'] ) ? sanitize_text_field( $_POST['option_name'] ) : '';
        $option_value = isset( $_POST['option_value'] ) ? sanitize_text_field( $_POST['option_value'] ) : '';
        $autoload = isset( $_POST['autoload'] ) ? sanitize_text_field( $_POST['autoload'] ) : '';

        // some basic validation
        if ( ! $option_name ) {
            $errors[] = __( 'Error: Option Name is required', '' );
        }

        if ( ! $option_value ) {
            $errors[] = __( 'Error: Option Value is required', '' );
        }

        if ( ! $autoload ) {
            $errors[] = __( 'Error: Autoload is required', '' );
        }


        // bail out if error found
        if ( $errors ) {

            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            //'option_id' => $option_id,
            'option_name' => $option_name,
            'option_value' => $option_value,
            'autoload' => $autoload,
        );

        // New or edit?
        if ( ! $field_id ) {
            $insert_id = op_insert_option( $fields );

        } else {
            $fields['option_id'] = $field_id;

            $insert_id = op_insert_option( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}

new Form_Handler();