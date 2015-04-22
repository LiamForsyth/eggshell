$.getJSON("../../../../" + sassfolder + "perch/theme.json", function( json ) {
	$.each(json, function(index, element) { 
		$('#perch_' + index).attr('data-default', element );
	});
});

(function( $ ){ $.fn.resetInput = function() { 
	var inputdefault = $(this).prev().data('default');$(this).prev().val(inputdefault);
}; })( jQuery );

$("#btnSubmit").after(' <input class="button" value="Reset All" id="reset_all" type="button">');

$('.field input:not("#eggshell_updateDefaults"), .field select:not("#eggshell_updateDefaults")').each(function( i ) {

	var id = $(this).attr('id');
	$(this).css('vertical-align','middle').after(' <input class="reset_var" value="Reset" id="reset_'+ id +'" type="button">');
	var name = $(this).attr('name').replace('perch_', '');
});

$('.field input.reset_var').on( "click", function(i){ $(this).resetInput(); });

$('input#reset_all').on( "click", function(){
	var r = confirm("Reset all styling? This will clear any unsaved changes.");
	if (r == true) { $('.field .reset_var').each(function(i) { $(this).resetInput();} ); }
});