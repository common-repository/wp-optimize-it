<div class="wrap">
	<h2>WP Optimize It <input name="save" type="submit" class="button button-primary button-large" id="wpl-save-settings" value="Save"></h2>
	<div id="icon-themes" class="icon32"><br></div>
			<h2 class="nav-tab-wrapper">
	   			<?php
	   				$plugin_arr = get_option( 'active_plugins', '' );
	   				$current = ( isset( $_GET['tab'] ) )?$_GET['tab']:'';
	   				$tabs = array( 	'general' => 'CSS and JS');
		    		foreach( $tabs as $tab => $name ){
		       			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
		        		echo "<a class='nav-tab$class' href='?page=wpl-settings&tab=$tab'>$name</a>";
		    		}
		    	?>
			</h2>
			<div id="poststuff" class="wpl-tab-content">
				<?php 
					if( $current == 'general' ||  $current == ''){
						require_once( 'tab-content/general.php' );
				 	}
				 ?>
				<div id="wpl-loader-panel">
					<div id="wpl-loader">
						<img src="<?php echo WPL.'/lib/images/loader.gif' ?>" />
					</div>	
				</div>
			</div>	
</div>

