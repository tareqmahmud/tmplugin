<div class="wrap">
    <!-- If there is a success message then show the message -->
	<?php if ( isset( $_GET['success'] ) ) : ?>
		<?php if ( $_GET['success'] == 'new-address' ) : ?>
            <div class="notice notice-success">
                <p>New Address Created Successfully</p>
            </div>
		<?php endif; ?>
		<?php if ( $_GET['success'] == 'delete-address' ) : ?>
            <div class="notice notice-success">
                <p>Address Deleted Successfully</p>
            </div>
		<?php endif; ?>
	<?php endif; ?>
    <h1 class="wp-heading-inline"><?php _e( 'Address List', 'tmplugin' ); ?></h1>
    <a href="<?php echo admin_url( 'admin.php?page=tmplugin&action=new' ); ?>" class="page-title-action">Add New</a>

    <form action="" method="post">
		<?php
		$address_list = new \TMPlugin\Admin\AddressBook_List();
		$address_list->prepare_items();
		$address_list->display();
		?>
    </form>

</div>
