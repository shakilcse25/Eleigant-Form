var $ = jQuery;
$(document).ready(function() {

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	var i = 0;
	jQuery("#add").on('click',function() {
		i++;
		var removeButton = "<div class=\"col-md-1 remove\"><input data-id=\""+ i +"\" type=\"button\" class=\"btn btn-danger remove-input\" value=\"-\" /></div>";
        var single_field = $('<div id="single_field'+ i +'" class="bg-light inner-form-group border p-4"> <div class="row"><div class="col-md-6"><label for="validationCustom01'+ i +'" class="form-label">Field Name</label><input type="text" class="form-control" id="field_name" name="elegant_form[field_name][]" value="" placeholder="Field Name" required=""></div> <div class="col-md-5"><label for="validationCustom02'+ i +'" class="form-label">Field Type</label><select name="elegant_form[field_type][]" class="form-control validationCustom02'+ i +'"><option value="input">Input Field</option><option value="checkbox">CheckBox</option><option value="text-area">Text Area</option><option value="radio">Radio</option></select></select></div>'+ removeButton +'</div></div>');
        $('.form_group').append(single_field);
    });

	$(document).on('click','.remove-input',function() {
		var id = $(this).attr('data-id');
		$('#single_field' + id).remove();
	})
	

});
