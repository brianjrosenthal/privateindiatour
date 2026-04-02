jQuery('#keyword').on('input', function() {
	jQuery.ajax({
		url: 'https://privateindiatour.com/wp-admin/admin-ajax.php',
		type:'POST',
		data:'action=grandtour_ajax_search_result&'+jQuery('#tour_search_form').serialize(),
		success:function(results) {
			jQuery("#autocomplete").html(results);
			
			if(results != '')
			{
				jQuery("#autocomplete").addClass('visible');
				jQuery("#autocomplete").show();
				
				jQuery('#autocomplete ul li a').mousedown(function() {
					jQuery("#autocomplete").attr('data-mousedown', true);
				});
			}
			else
			{
				jQuery("#autocomplete").hide();
			}
		}
	})
});

jQuery('#keyword').bind('focus', function () {
    jQuery("#autocomplete").addClass('visible');
});

jQuery('#keyword').bind('blur', function () {
	if(jQuery("#autocomplete").attr('data-mousedown') != 'true')
    {
    	jQuery("#autocomplete").removeClass('visible');
    }
});
