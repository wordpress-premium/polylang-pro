<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { // If uninstall not called from WordPress exit
	exit();
}

foreach ( get_users( array( 'fields' => 'ID' ) ) as $user_id ) {
	delete_user_meta( $user_id, 'pll_duplicate_content' );
}
