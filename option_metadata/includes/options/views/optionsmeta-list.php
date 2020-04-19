<div class="wrap">
    <h2><?php _e( 'Options Meta Data List', '' ); ?> <a href="<?php echo admin_url( 'admin.php?page=optionsmetadata&action=new' ); ?>" class="add-new-h2"><?php _e( 'Add New', '' ); ?></a></h2>

    <form method="post">
        <input type="hidden" name="page" value="ttest_list_table">

        <?php
        $list_table = new OptionsMetaData_List_Table();
        $list_table->prepare_items();
        $list_table->search_box( 'search', 'option_name' );
        $list_table->display();
        ?>
    </form>
</div>