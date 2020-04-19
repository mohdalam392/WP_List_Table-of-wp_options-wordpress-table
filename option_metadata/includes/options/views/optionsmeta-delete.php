<div class="wrap">
    <h1><?php _e( 'Delete Option', '' ); ?></h1>

    <?php $item = op_get_option( $option_id ); ?>
    <?php 
        op_delete_option($option_id);
        //swp_redirect(admin_url( 'admin.php?page=optionsmetadata' ));
        echo "<script>window.location.href='".admin_url( 'admin.php?page=optionsmetadata&message=deleted' )."';</script>";
    ?>

    
</div>