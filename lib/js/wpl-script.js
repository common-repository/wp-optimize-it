
jQuery(document).ready(function($){

$('#wpl-save-settings').click(function(){
	$('#wpl-loader-panel').fadeIn('slow');

	data_to_pass = [];
	
	$('.wpl-tab-content table tr.plugin-holder').each(function( i ){
		increm = 0;
		blocked_arr = [];
		$(this).find( '.selected-post-types' ).each(function( indx ){
			if( $(this).is(':checked') ){
				blocked_arr[increm] = $(this).val();
				increm++;
			}
		});
		data_to_pass[i] = { name: $(this).data('plugin-name'), blocked: blocked_arr};
		
	});

	//ajax call
	$.post(
		ajaxurl, {
			'action': 'wpl_save_settings',
			'data':   data_to_pass
		}, 
		function( response ){
			if(response=="success"){
				$('#wpl-loader-panel').fadeOut('slow');
			}	
		}
	);
});


	 
});