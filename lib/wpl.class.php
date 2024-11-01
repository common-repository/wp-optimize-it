<?php
class WPL{
	var $script_urls = '';

	function __construct( ) {

		add_action( 'admin_menu', array($this,'render_gui') );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_libs' ) );	
		//ajax
		add_action( 'wp_ajax_wpl_save_settings', array( $this, 'save_settings' ) );

		//clean Front end
		add_filter( 'script_loader_src', array( $this, 'remove_plugin_files' ) );
		add_filter( 'style_loader_src', array( $this, 'remove_plugin_files' ) );

	}
	
	function render_gui( ){
		add_submenu_page( 'tools.php','Optimize it','Optimize it', 'manage_options', 'wpl-settings', array($this,'render_backend') );
	}
	
	function render_backend( ){
		require_once( 'display/wpl-view.php' );
	}
	

	function enqueue_libs( $hook ){
		if( $hook == 'tools_page_wpl-settings' ){
			wp_enqueue_style( 'wpl-style', WPL.'lib/css/style.css' );
			wp_enqueue_script( 'wpl-script', WPL.'lib/js/wpl-script.js', array(), '1.0.0', true );
		}	
	}

	function save_settings( ){
		update_option( 'wpl_settings', $_POST['data'] );
		echo 'success';
		die();
	}

	function search_array( $name, $post_type ){
		$wpl_settings = get_option( 'wpl_settings', '' );
		if( !empty( $wpl_settings ) ){

				foreach( $wpl_settings as $wpl_data ){

				if ($wpl_data['name'] == $name ){
					if( isset( $wpl_data['blocked'] ) ){
		
						if( in_array( $post_type, $wpl_data['blocked'] )  ){
							return true;
						}
					}	
				}	
			}
		}
		
		return false;	
	}

	function remove_plugin_files( $url ){
    	if( is_admin() ) return $url;

    	$current_post_type = ( is_home() )? 'home page': get_post_type();
    	$wpl_settings = get_option( 'wpl_settings', '' );

		if( !empty( $wpl_settings ) ){

			foreach( $wpl_settings as $wpl_data ){
				if ( strpos( $url, $wpl_data['name'] )  ){	

					if( in_array( $current_post_type, $wpl_data['blocked'] ) ){
						return '';
					}
				}	
			}
		}

		return $url;

	}
				
}

 //initiate Main Class
 new WPL();

?>
