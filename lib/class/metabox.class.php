<?php
class WPLMetaBox{

	function __construct( ) {
		add_action( 'add_meta_boxes', array( $this, 'register_meta_box' ) );
		add_action( 'save_post',  array( $this, 'save_meta_box' ) );
		//clean Front end
		add_filter( 'script_loader_src', array( $this, 'remove_plugin_files' ) );
		add_filter( 'style_loader_src', array( $this, 'remove_plugin_files' ) );
	}

	function register_meta_box() {
	    add_meta_box( 'wpl-optimizer-box', __( 'Do not load', 'wpl-textdomain' ), array( $this, 'display_callback' ), 'page', 'side' );
	}


	function display_callback( $post ) {
	     $plugins = get_option('active_plugins');
	        foreach ( $plugins as $plugin ) {
	        	if( strpos( $plugin, 'wp_optimize_it.php' ) ){
					continue;
				}
				$meta = get_post_meta( $post->ID, 'do_not_load', true );
				$disabled_plugins = ( !empty( $meta ) )?get_post_meta( $post->ID, 'do_not_load', true ):array();
	        	$plugin_info = get_plugin_data( WP_PLUGIN_DIR .'/'. $plugin , false, true );
	        	echo  '<label><input name="do_not_load[]" '. ( ( in_array( $plugin , $disabled_plugins ) )?'checked':'' ).' type="checkbox" value="' . $plugin . '">'.$plugin_info['Name'].'</label><input type="hidden" name="wpl_meta_submitter" value="true"><br>';
	       
	    }
	}

	function save_meta_box( $post_id ) {
	    // Save logic goes here. Don't forget to include nonce checks!
	    if( isset( $_POST['wpl_meta_submitter'] ) ){
	   		update_post_meta( $post_id, 'do_not_load', $_POST['do_not_load'] );
		}
	}


	function remove_plugin_files( $url ){
    	if( is_admin() ) return $url;

    	$current_post_type = ( is_home() )? 'home page': get_post_type();
    	$wpl_settings = get_option( 'wpl_settings', '' );

    	$blocked_plugins = get_post_meta( get_the_ID( ) , 'do_not_load', true );

		if( !empty( $blocked_plugins ) ){

			foreach( $blocked_plugins as $blocked_data ){
				$blocked_plugin_arr = explode( '/', $blocked_data );
				if ( strpos( $url, $blocked_plugin_arr[0] )  ){	

						return '';	
				}	
			}
		}

		return $url;

	}
	

			
}

new WPLMetaBox( );

?>
