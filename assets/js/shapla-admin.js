(function( $ ) {
	
	//Initializing jQuery UI Datepicker
	$( '.datepicker' ).datepicker({
		dateFormat: 'MM dd, yy',
		changeMonth: true,
		changeYear: true,
		onClose: function( selectedDate ){
			$( '.datepicker' ).datepicker( 'option', 'minDate', selectedDate );
		}
	});
	
	$('.colorpicker').each(function(){
		$(this).wpColorPicker();
	});

})( jQuery );