<?php
/**
 * Init function
 */
if( !function_exists( 'otw_tgsw_widgets_init' ) ){
	
	function otw_tgsw_widgets_init(){
		
		global $otw_components, $wp_filesystem;
		
		if( isset( $otw_components['registered'] ) && isset( $otw_components['registered']['otw_shortcode'] ) ){
			
			$shortcode_components = $otw_components['registered']['otw_shortcode'];
			arsort( $shortcode_components );
			
			if( otw_init_filesystem() ){
				foreach( $shortcode_components as $shortcode ){
					if( $wp_filesystem->is_file( $shortcode['path'].'/widgets/otw_shortcode_widget.class.php' ) ){
						
						include_once( $shortcode['path'].'/widgets/otw_shortcode_widget.class.php' );
						break;
					}
				}
			}
		}
		register_widget( 'OTW_Shortcode_Widget' );
	}
}
/**
 * Init function
 */
if( !function_exists( 'otw_tgsw_init' ) ){
	
	function otw_tgsw_init(){
		
		global $otw_tgsw_plugin_url, $otw_tgsw_plugin_options, $otw_tgsw_shortcode_component, $otw_tgsw_shortcode_object, $otw_tgsw_form_component, $otw_tgsw_validator_component, $otw_tgsw_form_object, $wp_tgsw_cs_items, $otw_tgsw_js_version, $otw_tgsw_css_version, $wp_widget_factory, $otw_tgsw_factory_component, $otw_tgsw_factory_object, $otw_tgsw_plugin_id;
		
		if( is_admin() ){
			
			include_once( 'otw_tgsw_process_actions.php' );
			
			add_action('admin_menu', 'otw_tgsw_init_admin_menu' );
			
			add_action('admin_print_styles', 'otw_tgsw_enqueue_admin_styles' );
			
			add_action('admin_enqueue_scripts', 'otw_tgsw_enqueue_admin_scripts');
			
			add_filter('otwfcr_notice', 'otw_tgsw_factory_message' );
		}
		otw_tgsw_enqueue_styles();
		
		include_once( plugin_dir_path( __FILE__ ).'otw_tgsw_dialog_info.php' );
		
		//shortcode component
		$otw_tgsw_shortcode_component = otw_load_component( 'otw_shortcode' );
		$otw_tgsw_shortcode_object = otw_get_component( $otw_tgsw_shortcode_component );
		$otw_tgsw_shortcode_object->js_version = $otw_tgsw_js_version;
		$otw_tgsw_shortcode_object->css_version = $otw_tgsw_css_version;
		$otw_tgsw_shortcode_object->editor_button_active_for['page'] = true;
		$otw_tgsw_shortcode_object->editor_button_active_for['post'] = true;
		
		$otw_tgsw_shortcode_object->add_default_external_lib( 'css', 'style', get_stylesheet_directory_uri().'/style.css', 'live_preview', 10 );
		
		if( isset( $otw_tgsw_plugin_options['otw_tgsw_theme_css'] ) && strlen( $otw_tgsw_plugin_options['otw_tgsw_theme_css'] ) ){
			
			if( preg_match( "/^http(s)?\:\/\//", $otw_tgsw_plugin_options['otw_tgsw_theme_css'] ) ){
				$otw_tgsw_shortcode_object->add_default_external_lib( 'css', 'theme_style', $otw_tgsw_plugin_options['otw_tgsw_theme_css'], 'live_preview', 11 );
			}else{
				$otw_tgsw_shortcode_object->add_default_external_lib( 'css', 'theme_style', get_stylesheet_directory_uri().'/'.$otw_tgsw_plugin_options['otw_tgsw_theme_css'], 'live_preview', 11 );
			}
		}
		
		$otw_tgsw_shortcode_object->shortcodes['content_toggle'] = array( 'title' => esc_html__('Content toggle', 'otw_tgsw'),'enabled' => true,'children' => false, 'parent' => false, 'order' => 8,'path' => dirname( __FILE__ ).'/otw_components/otw_shortcode/', 'url' => $otw_tgsw_plugin_url.'include/otw_components/otw_shortcode/', 'dialog_text' => $otw_tgsw_dialog_text  );

		
		include_once( plugin_dir_path( __FILE__ ).'otw_labels/otw_tgsw_shortcode_object.labels.php' );
		$otw_tgsw_shortcode_object->init();
		
		//form component
		$otw_tgsw_form_component = otw_load_component( 'otw_form' );
		$otw_tgsw_form_object = otw_get_component( $otw_tgsw_form_component );
		$otw_tgsw_form_object->js_version = $otw_tgsw_js_version;
		$otw_tgsw_form_object->css_version = $otw_tgsw_css_version;
		
		include_once( plugin_dir_path( __FILE__ ).'otw_labels/otw_tgsw_form_object.labels.php' );
		$otw_tgsw_form_object->init();
		
		//validator component
		$otw_tgsw_validator_component = otw_load_component( 'otw_validator' );
		$otw_tgsw_validator_object = otw_get_component( $otw_tgsw_validator_component );
		$otw_tgsw_validator_object->init();
		
		$otw_tgsw_factory_component = otw_load_component( 'otw_factory' );
		$otw_tgsw_factory_object = otw_get_component( $otw_tgsw_factory_component );
		$otw_tgsw_factory_object->add_plugin( $otw_tgsw_plugin_id, dirname( dirname( __FILE__ ) ).'/otw_content_manager.php', array( 'menu_parent' => 'otw-tgsw-settings', 'lc_name' => esc_html__( 'License Manager', 'otw_tgsw' ), 'menu_key' => 'otw-tgsw' ) );
		
		include_once( plugin_dir_path( __FILE__ ).'otw_labels/otw_tgsw_factory_object.labels.php' );
		$otw_tgsw_factory_object->init();
		
	}
}

/**
 * include needed styles
 */
if( !function_exists( 'otw_tgsw_enqueue_styles' ) ){
	function otw_tgsw_enqueue_styles(){
		global $otw_tgsw_plugin_url, $otw_tgsw_css_version;
	}
}


/**
 * Admin styles
 */
if( !function_exists( 'otw_tgsw_enqueue_admin_styles' ) ){
	
	function otw_tgsw_enqueue_admin_styles(){
		
		global $otw_tgsw_plugin_url, $otw_tgsw_css_version;
		
		wp_enqueue_style( 'otw_tgsw_admin', $otw_tgsw_plugin_url.'/css/otw_tgsw_admin.css', array( 'thickbox' ), $otw_tgsw_css_version );
	}
}

/**
 * Admin scripts
 */
if( !function_exists( 'otw_tgsw_enqueue_admin_scripts' ) ){
	
	function otw_tgsw_enqueue_admin_scripts( $requested_page ){
		
		global $otw_tgsw_plugin_url, $otw_tgsw_js_version;
		
		switch( $requested_page ){
			
			case 'widgets.php':
					wp_enqueue_script("otw_shotcode_widget_admin", $otw_tgsw_plugin_url.'include/otw_components/otw_shortcode/js/otw_shortcode_widget_admin.js'  , array( 'jquery', 'thickbox' ), $otw_tgsw_js_version );
					
					if(function_exists( 'wp_enqueue_media' )){
						wp_enqueue_media();
					}else{
						wp_enqueue_style('thickbox');
						wp_enqueue_script('media-upload');
						wp_enqueue_script('thickbox');
					}
				break;
		}
	}
	
}

/**
 * Init admin menu
 */
if( !function_exists( 'otw_tgsw_init_admin_menu' ) ){
	
	function otw_tgsw_init_admin_menu(){
		
		global $otw_tgsw_plugin_url;
		
		add_menu_page(__('Toggles Shortcode And Widget', 'otw_tgsw'), esc_html__('Toggles Shortcode And Widget', 'otw_tgsw'), 'manage_options', 'otw-tgsw-settings', 'otw_tgsw_settings', $otw_tgsw_plugin_url.'images/otw-sbm-icon.png');
		add_submenu_page( 'otw-tgsw-settings', esc_html__('Settings', 'otw_tgsw'), esc_html__('Settings', 'otw_tgsw'), 'manage_options', 'otw-tgsw-settings', 'otw_tgsw_settings' );

	}
}

/**
 * Settings page
 */
if( !function_exists( 'otw_tgsw_settings' ) ){
	
	function otw_tgsw_settings(){
		require_once( 'otw_tgsw_settings.php' );
	}
}



/**
 * Keep the admin menu open
 */
if( !function_exists( 'otw_open_tgsw_menu' ) ){
	
	function otw_open_tgsw_menu( $params ){
		
		global $menu;
		
		foreach( $menu as $key => $item ){
			if( $item[2] == 'otw-cm-settings' ){
				$menu[ $key ][4] = $menu[ $key ][4].' wp-has-submenu wp-has-current-submenu wp-menu-open menu-top otw-menu-open';
			}
		}
	}
}

/**
 * factory messages
 */
if( !function_exists( 'otw_tgsw_factory_message' ) ){
	
	function otw_tgsw_factory_message( $params ){
		
		global $otw_tgsw_plugin_id;
		
		if( isset( $params['plugin'] ) && $otw_tgsw_plugin_id == $params['plugin'] ){
			
			//filter out some messages if need it
		}
		if( isset( $params['message'] ) )
		{
			return $params['message'];
		}
		return $params;
	}
}
?>