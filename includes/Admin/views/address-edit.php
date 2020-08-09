<?php
//If address not available then throw a message and stop render the form
if ( ! $address ) {
	echo "<h2>Invalid Address ID</h2>";

	return;
}
?>

<div class="wrap">
    <!-- If there is a success message then show the message -->
	<?php if ( isset( $_GET['success'] ) ) : ?>
		<?php if ( $_GET['success'] == 'edit-address' ) : ?>
            <div class="notice notice-success">
                <p>Address Updated Successfully</p>
            </div>
		<?php endif; ?>
	<?php endif; ?>

    <h1 class="wp-heading-inline"><?php _e( 'Edit Address', 'tmplugin' ); ?></h1>
    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row<?php echo $this->has_error( 'name' ) ? ' form-invalid' : ''; ?>">
                    <th scope="row">
                        <label for="name"><?php _e( 'Name', 'tmplugin' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text"
                               value="<?php echo esc_attr( $address->name ); ?>">
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
                        <textarea class="regular-text" rows="5" name="address"
                                  id="address"><?php echo esc_textarea( $address->address ); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="phone"><?php _e( 'Phone', 'tmplugin' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="phone" id="phone" class="regular-text"
                               value="<?php echo esc_attr( $address->phone ); ?>">
                    </td>
                </tr>
                <input type="hidden" name="id" value="<?php echo $address->id; ?>">
            </tbody>
        </table>
		<?php wp_nonce_field( 'new-address' ); ?>
		<?php submit_button( __( 'Update Address', 'tmplugin' ), 'primary', 'submit_address' ); ?>
    </form>
</div>
