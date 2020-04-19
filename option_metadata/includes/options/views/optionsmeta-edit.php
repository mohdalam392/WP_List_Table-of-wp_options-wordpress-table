<div class="wrap">
    <h1><?php _e( 'Update Option', '' ); ?></h1>

    <?php $item = op_get_option( $option_id ); ?>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-option-id" style="display: none">
                    <th scope="row">
                        <label for="option_id"><?php _e( 'Option Id', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="option_id" id="option_id" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="<?php echo esc_attr( $item->option_id ); ?>" />
                    </td>
                </tr>
                <tr class="row-option-name">
                    <th scope="row">
                        <label for="option_name"><?php _e( 'Option Name', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="option_name" id="option_name" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="<?php echo esc_attr( $item->option_name ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-option-value">
                    <th scope="row">
                        <label for="option_value"><?php _e( 'Option Value', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="option_value" id="option_value" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="<?php echo esc_attr( $item->option_value ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-autoload">
                    <th scope="row">
                        <label for="autoload"><?php _e( 'Autoload', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="autoload" id="autoload" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="<?php echo esc_attr( $item->autoload ); ?>" required="required" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="<?php echo $item->option_id; ?>">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Update Option', '' ), 'primary', 'Submit Option' ); ?>

    </form>
</div>