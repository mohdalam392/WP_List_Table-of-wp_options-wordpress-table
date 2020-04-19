<div class="wrap">
    <h1><?php _e( 'Add New Option', '' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
               <!--  <tr class="row-option-id">
                    <th scope="row">
                        <label for="option_id"><?php //_e( 'Option Id', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="option_id" id="option_id" class="regular-text" placeholder="<?php //echo esc_attr( '', '' ); ?>" value="" />
                    </td>
                </tr> -->
                <tr class="row-option-name">
                    <th scope="row">
                        <label for="option_name"><?php _e( 'Option Name', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="option_name" id="option_name" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-option-value">
                    <th scope="row">
                        <label for="option_value"><?php _e( 'Option Value', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="option_value" id="option_value" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-autoload">
                    <th scope="row">
                        <label for="autoload"><?php _e( 'Autoload', '' ); ?></label>
                    </th>
                    <td>
                        <select name="autoload">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Add New Option', '' ), 'primary', 'Submit Option' ); ?>

    </form>
</div>