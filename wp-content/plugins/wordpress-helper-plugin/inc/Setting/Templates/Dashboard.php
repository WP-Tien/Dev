<div class="wrap">
	<h1>Admin Dashboard</h1>
	<?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php 
            settings_fields( 'apis_plugin_settings' );
            do_settings_sections( 'apis_plugin' );
            submit_button();
        ?>
    </form>
</div>