<?php

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class OptionsMetaData_List_Table extends \WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'Option',
            'plural'   => 'Options',
            'ajax'     => false
        ) );
    }

    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    function no_items() {
        _e( 'No Option Found', '' );
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default( $item, $column_name ) {

        switch ( $column_name ) {
            case 'option_id':
                return $item->option_id;

            case 'option_name':
                return $item->option_name;

            case 'option_value':
                return $item->option_value;

            case 'autoload':
                return $item->autoload;

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'           => '<input type="checkbox" />',
            'option_id'      => __( 'Option Id', '' ),
            'option_name'      => __( 'Option Name', '' ),
            'option_value'      => __( 'Option Value', '' ),
            'autoload'      => __( 'Autoload', '' ),

        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_option_id( $item ) {

        $actions           = array();
        $actions['edit']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=optionsmetadata&action=edit&option_id=' . $item->option_id ), $item->option_id, __( 'Edit this item', '' ), __( 'Edit', '' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=optionsmetadata&action=delete&option_id=' . $item->option_id ), $item->option_id, __( 'Delete this item', '' ), __( 'Delete', '' ) );

        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=optionsmetadata&action=view&option_id=' . $item->option_id ), $item->option_id, $this->row_actions( $actions ) );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'option_id' => array( 'Option Id', true ),
            'option_name' => array( 'Option Name', true ),
            'option_value' => array( 'Option Value', true ),
            'autoload' => array( 'Autoload', true ),
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            //'trash'  => __( 'Move to Trash', '' ),
        );
        return $actions;
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="Option_id[]" value="%d" />', $item->option_id
        );
    }

    public function extra_tablenav($which)
    {
        $option_id = sanitize_text_field( $_POST['option_id'] );
        $option_name = sanitize_text_field( $_POST['option_name'] );
        $option_value = sanitize_text_field( $_POST['option_value'] );
        $autoload = sanitize_text_field( $_POST['autoload'] );
    ?>
        <div class="alignleft actions daterangeactions">
            <form name='searchfilter'>
                <label for="daterange-actions-picker" class="screen-reader-text"><?=__('Filter', 'iw-stats')?></label>
                <input type="textfield" name="option_id" id="option_id" placeholder="Option Id" value="<?php echo $option_id ?>"/>
                <input type="textfield" name="option_name" id="option_name" placeholder="Option Name" value="<?php echo $option_name ?>"/>
                <input type="textfield" name="option_value" id="option_value" placeholder="Option Value" value="<?php echo $option_value ?>"/>
                <input type="textfield" name="autoload" id="autoload" placeholder="Autoload" value="<?php echo $autoload ?>"/>
                <?php wp_nonce_field( '' ); ?>
            <?php submit_button(__('Apply', 'iw-stats'), 'action', 'dodate', false); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views() {
        $status_links   = array();
        $base_link      = admin_url( 'admin.php?page=sample-page' );

        foreach ($this->counts as $key => $value) {
            $class = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg( array( 'status' => $key ), $base_link ), $class, $value['label'], $value['count'] );
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items() {

        $columns               = $this->get_columns();
        $hidden                = array( );
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page              = 20;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '2';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        if ( isset( $_REQUEST['s'] ) && !empty( $_REQUEST['s'] ) ) {
            $args['s'] = $_REQUEST['s'];
        }

         if ( isset( $_POST['option_id'] ) && !empty( $_POST['option_id'] ) ) {
            $args['option_id'] = sanitize_text_field($_POST['option_id']);
        }
        if ( isset( $_POST['option_name'] ) && !empty( $_POST['option_name'] ) ) {
            $args['option_name'] = sanitize_text_field($_POST['option_name']);
        }
        if ( isset( $_POST['option_value'] ) && !empty( $_POST['option_value'] ) ) {
            $args['option_value'] = sanitize_text_field($_POST['option_value']);
        }
        if ( isset( $_POST['autoload'] ) && !empty( $_POST['autoload'] ) ) {
            $args['autoload'] = sanitize_text_field($_POST['autoload']);
        }


        $this->items  = op_get_all_Option( $args );

        $this->set_pagination_args( array(
            'total_items' => op_get_Option_count(),
            'per_page'    => $per_page
        ) );
    }
}