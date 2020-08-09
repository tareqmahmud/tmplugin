<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'New Address', 'tmplugin' ); ?></h1>
    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row<?php echo $this->has_error( 'name' ) ? ' form-invalid' : ''; ?>">
                    <th scope="row">
                        <label for="name"><?php _e( 'Name', 'tmplugin' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" value="">
						<?php if ( $this->has_error( 'name' ) ) : ?>
                            <p class="description error"><?php echo $this->get_error( 'name' ); ?></p>
						<?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="address"><?php _e( 'Address', 'tmplugin' ); ?></label>
                    </th>
                    <td>
                        <textarea class="regular-text" rows="5" name="address" id="address"></textarea>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="phone"><?php _e( 'Phone', 'tmplugin' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="phone" id="phone" class="regular-text" value="">
                    </td>
                </tr>
            </tbody>
        </table>
		<?php wp_nonce_field( 'new-address' ); ?>
		<?php submit_button( __( 'Add Address', 'tmplugin' ), 'primary', 'submit_address' ); ?>
    </form>
</div>
