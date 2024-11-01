<?php
class OICache{

	function __construct( ) {

		add_action( 'init', array( $this, 'start_caching' ) );
	}
	

	
	function render_backend( ){
		require_once( 'display/wpl-view.php' );
	}

	function top_cache( ){

		$url = $_SERVER["SCRIPT_NAME"];
		$break = Explode('/', $url);
		$file = $break[count($break) - 1];
		$cachefile = 'cached-'.substr_replace($file ,"",-4).'.html';
		$cachetime = 18000;

		// Serve from the cache if it is younger than $cachetime
		if (file_exists( $cachefile ) && time() - $cachetime < filemtime($cachefile)) {
		    echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
		    include( $cachefile );
		    exit;
		}
		ob_start(); // Start the output buffer
	}

	function bottom_cache( ){
	// Cache the contents to a file
	$cached = fopen($cachefile, 'w');
	fwrite($cached, ob_get_contents());
	fclose($cached);
	ob_end_flush(); // Send the output to the browser

	}
	


			
}

new OICache( );

?>
