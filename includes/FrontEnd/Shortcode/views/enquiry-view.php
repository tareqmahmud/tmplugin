<form action="" method="post" id="tmplugin-enquiry-form">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
    </div>

    <div class="form-group">
        <label for="message">Message</label>
        <textarea name="message" id="message" class="form-control" cols="30" rows="10"></textarea>
    </div>
	<?php wp_nonce_field( 'tmplugin-wp-enquiry-nonce' ); ?>
    <input type="hidden" name="action" value="tmplugin_wp_enquiry_nonce">
    <div class="form-group">
        <input type="submit" name="enquiry" value="Submit" class="btn btn-success btn-lg">
    </div>
</form>
