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
		var removeButton = "<input data-id=\""+ i +"\" type=\"button\" class=\"btn btn-danger remove-input\" value=\"-\" />";
        var single_field = $('<div id="single_field'+ i +'" class="bg-light inner-form-group border p-4"> <div class="row"><div class="col-md-6"><label for="validationCustom01'+ i +'" class="form-label">Label Name</label><input type="text" class="form-control" id="field_name" name="elegant_form[field_name][]" value="" placeholder="Field Name" required=""></div> <div class="col-md-6"><label for="validationCustom02'+ i +'" class="form-label">Field Type</label><select name="elegant_form[field_type][]" class="form-select field_type validationCustom02'+ i +'"><option value="input">Input Field</option><option value="checkbox">CheckBox</option><option value="text-area">Text Area</option><option value="dropdown">DropDown</option></select></select></div></div>'+ removeButton +'</div>');
        $('.form_group').append(single_field);
    });

	$(document).on('click','.remove-input',function() {
		var id = $(this).attr('data-id');
		$('#single_field' + id).remove();
	})

	$(document).on('change','.field_type',function() {
		var type = $(this).val();
		if(type == 'dropdown'){
			$dynamic_option = $('<div class="dynamic_option"><div class="dynamic_select"><ul class="list-group dynamic-list-option"></ul></div><div class="add_option"><input type="text" id="single_option" class="form-control" /> <button class="btn btn-primary add_option_button" type="button" >Add Option</button> </div></div>');
			$(this).after($dynamic_option);
		}else{
			if($(this).next().hasClass('dynamic_option')){
				$(this).next().remove();
			}
		}
		
	})

	$(document).on('click','.add_option_button',function() {
		var field_name = $(this).parent().parent().parent().prev().children('input').val();
		var dynamic_select = $(this).parent().prev();
		var option_value = $(this).prev().val();
		if(option_value !== ''){
			dynamic_select.children('.dynamic-list-option').append($('<li  class="list-group-item"><input type="text"  class="form-control" name="elegant_form[options]['+ field_name +'][]" value="'+ option_value +'" readonly /></li>'));
			$(this).prev().val('');
		}
	})


	$(document).on('keydown','#single_option',function(e) {
		if(e.which === 13){
			e.preventDefault();
			var field_name = $(this).parent().parent().parent().prev().children('input').val();
			var dynamic_select = $(this).parent().prev();
			var option_value = $(this).val();
			if(option_value !== ''){
				dynamic_select.children('.dynamic-list-option').append($('<li  class="list-group-item option-list"><input type="text" class="form-control" name="elegant_form[options]['+ field_name +'][]" value="'+ option_value +'" readonly /><button type="button" class="btn-close option-close" aria-label="Close"></button></li>'));
				$(this).val('');
			}
		}
	})

	$(document).on('click','.option-close', function(){
		$(this).parent().remove();
	});

});
