<?php

/**
 * Get all Option
 *
 * @param $args array
 *
 * @return array
 */
function op_get_all_Option( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'option_id',
        'order'      => 'ASC',
        's'         =>'',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'Option-all';
    $items     = wp_cache_get( $cache_key, '' );

    if ( false === $items ) {
        if(empty($args['s'])){

            $query = 'SELECT * FROM ' . $wpdb->prefix . 'options where 1=1 ';

            if(!empty($args['option_id'])){
                $query  .='and option_id="'.$args['option_id'].'" ';
            }
            if(!empty($args['option_name'])){
                $query  .='and option_name="'.$args['option_name'].'" ';
            }
            if(!empty($args['option_value'])){
                $query  .='and option_value="'.$args['option_value'].'" ';
            }
            if(!empty($args['autoload'])){
                $query  .='and autoload="'.$args['autoload'].'" ';
            }

            $query  .='ORDER BY option_id ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'];
            
            $items = $wpdb->get_results( $query );

        }else{
            $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'options where option_name like "%'.$args['s'].'%" or option_value like "%'.$args['s'].'%" ORDER BY  option_id ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );
        }
        wp_cache_set( $cache_key, $items, '' );
    }

    return $items;
}

/**
 * Fetch all Option from database
 *
 * @return array
 */
function op_get_Option_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'options' );
}

/**
 * Fetch a single Option from database
 *
 * @param int   $id
 *
 * @return array
 */
function op_get_Option( $option_id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'options WHERE option_id = %d', $option_id ) );
}

function op_delete_option( $option_id = 0 ) {
    global $wpdb;
    $wpdb->delete( $wpdb->prefix.'options',array('option_id'=>$option_id));
}

/**
 * Insert a new option
 *
 * @param array $args
 */
function op_insert_option( $args = array() ) {
    global $wpdb;

    $defaults = array(
        //'option_id' => '',
        'option_name' => '',
        'option_value' => '',
        'autoload' => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'options';

    // some basic validation
    if ( empty( $args['option_name'] ) ) {
        return new WP_Error( 'no-option_name', __( 'No Option Name provided.', '' ) );
    }
    if ( empty( $args['option_value'] ) ) {
        return new WP_Error( 'no-option_value', __( 'No Option Value provided.', '' ) );
    }
    if ( empty( $args['autoload'] ) ) {
        return new WP_Error( 'no-autoload', __( 'No Autoload provided.', '' ) );
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['option_id'];
    unset( $args['option_id'] );

    if ( ! $row_id ) {

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {
        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'option_id' => $row_id ) ) ) {
            return $row_id;
        }else{
            die( $wpdb->show_errors());
        }
    }

    return false;
}