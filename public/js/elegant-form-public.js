var $ = jQuery;
$(document).ready(function() {

	/**
	 * All of the code for your public-facing JavaScript source
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

	$('#elegant-form').on('submit',function(e){
		e.preventDefault();
		Notiflix.Loading.Hourglass('Sending...');
		var url = $(this).attr('data-url');
		var allcheck = [];
		$('#elegant-form .input-text-checkbox').each(function() {
			allcheck.push($(this).attr('name'));
		});
		var formData = $(this).serializeArray().reduce(function(obj, item) {
			obj[item.name] = item.value;
			return obj;
		}, {});


		$.ajax({
			type: "POST",
			url: url,
			data:formData,
			success: function(response){
				//if request if made successfully then the response represent the data
				console.log(response);
				Notiflix.Loading.Remove();
				if(response.status == 'success'){
					Notiflix.Notify.Success('Sent Successfully!', {cssAnimationStyle:'zoom', cssAnimationDuration:500 , position: 'right-bottom'});
				}else{
					Notiflix.Report.Failure('Something Wrong!','<p style="text-align:center;">Please try again later.</p>', {cssAnimationStyle:'zoom', cssAnimationDuration:500 });
				}
			},
			error: function(e) {
				Notiflix.Loading.Remove();
				console.log(e);
				Notiflix.Report.Failure('Something Wrong!','<p style="text-align:center;">Please try again later.</p>', {cssAnimationStyle:'zoom', cssAnimationDuration:500 });
			},

		});

	});

 });
