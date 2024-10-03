<?php
/**
 * Process otw cm actions
 *
 */
if( otw_post( 'otw_tgsw_action', false ) ){
	
	require_once( ABSPATH . WPINC . '/pluggable.php' );
	
	switch( otw_post( 'otw_tgsw_action', '' ) ){
		
		case 'otw_tgsw_settings_action':
				
				if( otw_post( 'otw_cm_promotions', false ) && !empty( otw_post( 'otw_cm_promotions', '' ) ) ){
					
					global $otw_tgsw_factory_object, $otw_tgsw_plugin_id;
					
					update_option( $otw_tgsw_plugin_id.'_dnms', otw_post( 'otw_cm_promotions', '' ) );
					
					if( is_object( $otw_tgsw_factory_object ) ){
						$otw_tgsw_factory_object->retrive_plungins_data( true );
					}
				}
				
				wp_redirect( admin_url( 'admin.php?page=otw-tgsw-settings&message=1' ) );
			break;
	}
}
?>