<table class="table-fill">
					<thead>
					<tr>
					<th class="text-left">Plugin Name</th>
					<th class="text-left">Do not Load on:</th>
					</tr>
					</thead>
					<tbody class="table-hover">
						<?php 

							if( !empty( $plugin_arr ) ): 
								foreach( $plugin_arr as $plugin_data ) : 
								$plugin_info = get_plugin_data( WP_PLUGIN_DIR. '/' . $plugin_data );	

								if( strpos( $plugin_data, 'wp_optimize_it.php' ) ){
									continue;
								}
								$plugin_marker = explode( '/', $plugin_data );
						?>
							<tr class="plugin-holder" data-plugin-name="<?php echo $plugin_marker[0]; ?>" >
								<td class="text-left"><div class="plugin-name-holder"><?php echo $plugin_info['Name'] ?></div></td>
								<td class="text-left">
									<?php
										echo '<div class="pt-holder"><label><input class="selected-post-types" type="checkbox" value="home page" '.( $this->search_array( $plugin_marker[0], 'home page' )?'checked':'' ).' />home page</label></div>';
										$args = array( 'public' => true );
										foreach ( get_post_types( $args ) as $post_type ) {

											echo '<div class="pt-holder">
													<label>
													<input class="selected-post-types" type="checkbox" value="'.$post_type.'" '.( $this->search_array( $plugin_marker[0], $post_type )?'checked':'' ).' />'. $post_type . '
													</label>
													</div>';
										}
									?>
								</td>
							</tr>
						<?php 
								endforeach;
							endif;		
						?>
					</tbody>
					</table>