var $ = jQuery;
Dropzone.autoDiscover = false;
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

	// $('#elegant-form').on('submit',function(e){
	// 	e.preventDefault();
	// 	Notiflix.Loading.Hourglass('Sending...');
	// 	var url = $(this).attr('data-url');
	// 	var allcheck = [];
	// 	$('#elegant-form .input-text-checkbox').each(function() {
	// 		allcheck.push($(this).attr('name'));
	// 	});
	// 	var formData = $(this).serializeArray().reduce(function(obj, item) {
	// 		obj[item.name] = item.value;
	// 		return obj;
	// 	}, {});

	// 	myDropzone.processQueue();


	// 	$.ajax({
	// 		type: "POST",
	// 		url: url,
	// 		data:formData,
	// 		success: function(response){
	// 			//if request if made successfully then the response represent the data
	// 			console.log(response);
	// 			Notiflix.Loading.Remove();
	// 			if(response.status == 'success'){
	// 				Notiflix.Notify.Success('Sent Successfully!', {cssAnimationStyle:'zoom', cssAnimationDuration:500 , position: 'right-bottom'});
	// 			}else{
	// 				Notiflix.Report.Failure('Something Wrong!','<p style="text-align:center;">Please try again later.</p>', {cssAnimationStyle:'zoom', cssAnimationDuration:500 });
	// 			}
	// 		},
	// 		error: function(e) {
	// 			Notiflix.Loading.Remove();
	// 			console.log(e);
	// 			Notiflix.Report.Failure('Something Wrong!','<p style="text-align:center;">Please try again later.</p>', {cssAnimationStyle:'zoom', cssAnimationDuration:500 });
	// 		},

	// 	});

	// });


	
	var url = $('#elegant-form').attr('data-url');
	var myDropzone = new Dropzone("#dropzoneDragArea", {
		url: url,
		previewsContainer: '#dropzone-previews',
		addRemoveLinks: true,
		parallelUploads: 100,
		autoProcessQueue: false,
		uploadMultiple: true,
		maxFiles: 10,
		// The setting up of the dropzone
		init: function () {
			var myDropzone = this;
			//form submission code goes here
			$('#elegant-form').on('submit', function (event) {
				//Make sure that the form isn't actully being sent.
				event.preventDefault();
				Notiflix.Loading.Hourglass('Sending...');
				var allcheck = [];
				$('#elegant-form .input-text-checkbox').each(function() {
					allcheck.push($(this).attr('name'));
				});
				var formData = $(this).serializeArray().reduce(function (obj, item) {
					obj[item.name] = item.value;
					return obj;
				}, {});
				myDropzone.processQueue();

				// $.ajax({
				// 	type: "POST",
				// 	url: url,
				// 	data: formData,
				// 	success: function (response) {
				// 		//if request if made successfully then the response represent the data
				// 		console.log(response);
				// 		Notiflix.Loading.Remove();
				// 		if (response.status == 'success') {
				// 			Notiflix.Notify.Success('Sent Successfully!', { cssAnimationStyle: 'zoom', cssAnimationDuration: 500, position: 'right-bottom' });
				// 		} else {
				// 			Notiflix.Report.Failure('Something Wrong!', '<p style="text-align:center;">Please try again later.</p>', { cssAnimationStyle: 'zoom', cssAnimationDuration: 500 });
				// 		}
				// 	},
				// 	error: function (e) {
				// 		Notiflix.Loading.Remove();
				// 		console.log(e);
				// 		Notiflix.Report.Failure('Something Wrong!', '<p style="text-align:center;">Please try again later.</p>', { cssAnimationStyle: 'zoom', cssAnimationDuration: 500 });
				// 	},

				// });
			});
			//Gets triggered when we submit the image.
			// this.on('sending', function (file, xhr, formData) {
			// 	//fetch the user id from hidden input field and send that userid with our image
			// 	let userid = document.getElementById('userid').value;
			// 	formData.append('userid', userid);
			// });

			this.on("success", function (file, response) {
				Notiflix.Loading.Remove();
				//reset the form
				$('#elegant-form')[0].reset();
				//reset dropzone
				$('.dropzone-previews').empty();
				console.log(response);
			});



			this.on("sending", function (data, xhr, formData) {
				var newData = $('#elegant-form').serializeArray();
				newData.forEach((element) => {
					formData.append(element.name, element.value);
				});
			});

			this.on("error", function (file, errorMessage, xhr) {
				//Do something if there is an error.
				//This is where I like to alert to the user what the error was and reload the page after. 
				alert(errorMessage);
			})
		}
	});





 });
