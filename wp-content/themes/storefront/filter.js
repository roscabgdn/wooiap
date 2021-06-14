(function($) {
	$doc = $(document);
	$doc.ready( function() {
		function set_zone() {
			$container = $('#response');
			$status    = $container.find('.loading_zone');
	    	$status.text('Loading posts...');
	    	
			$.ajax({
	    		url: zebra.ajax_url,
	    		data: {
	    			action: 'do_add_shipping_zone_to_session',
	    			nonce: zebra.nonce,
	    			params: $params
	    		},
	    		type: 'POST',
	    		dataType: 'json',
	    		success: function(data, textStatus, XMLHttpRequest) {
	    			if (data.status === 200) {
	    				console.log('1');
	    			} else if ( data.status === 201 ) {
	    				console.log('2');
	    			} else {
	    				console.log('3');
	    			}
	    		},
	    		error: function(MLHttpRequest, textStatus, errorThrown) {
					
		        },
		        complete: function(data, textStatus) {
						
					msg = textStatus;

	            	if (textStatus === 'success') {
	            		msg = data.responseJSON.found;
	            	}

	            	$status.text('Posts found: ' + msg);
	            	
	            }
	    	})
		}

		// $('#zone_filter').on('change', 'select ', function(event) {
		// 	if(event.preventDefault) { event.preventDefault(); }
		// 	$params = {
		// 		'zona' : $('#zone_livrare').val(),				
		// 	}
		// 	// Run query
	 //        set_zone($params);
		// });

		$('#zone_filter').on('click', 'button ', function(event) {
			if(event.preventDefault) { event.preventDefault(); }
			$params = {
				'zona' : $('#zone_livrare').val(),				
			}
			console.log(params);
			// Run query
	        set_zone($params);
		});
	});
})(jQuery);