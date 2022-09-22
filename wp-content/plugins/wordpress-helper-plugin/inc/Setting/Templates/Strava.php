<div class="wrap">
	<h1> <?php echo esc_html__( 'Admin Strava', 'apis' ) ?></h1>
	<?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php 
            settings_fields( $this->strava_settings );
            do_settings_sections( $this->strava_slug );
            submit_button();
        ?>
    </form>
</div>