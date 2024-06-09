<?php
/**
 * Show updates status messages.
 */
    if (!empty($db_upgrade)) {
        if (!empty($db_upgrade->getAppliedUpdates())) {
            $updates_made = 1;
        };
    }


	if ( isset( $updates_error_messages ) && !empty( $updates_error_messages ) ) {
?>
		<div class="row">
			<div class="col-sm-12">
				<?php
					foreach ( $updates_error_messages as $updates_error_msg ) {
						echo system_message( 'error', $updates_error_msg );
					}
				?>
			</div>
		</div>
<?php
	}
