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


	var captcha = false;
	if($("#cpatchaTextBox").length){
		createCaptcha();
		captcha = true;
	}
	var captchaMath = false;
	if($(".math-captcha").length){
		randomnum();
		captchaMath = true;
	}

	var dropzone = document.getElementsByClassName('elegant-form-text-captcha');
	if(dropzone.length){
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
					var validcaptchaText = true;
					var validcaptchaMath = true;
					if(captcha){
						if(!validateCaptcha()){
							validcaptchaText = false;
						}
					}
					if(captchaMath){
						if(!validateMathCaptcha()){
							validcaptchaMath = false;
						}
					}
					
					
					if(validcaptchaText && validcaptchaMath){
						
						var allcheck = [];
						$('#elegant-form .input-text-checkbox').each(function() {
							allcheck.push($(this).attr('name'));
						});

						Notiflix.Loading.Hourglass('Sending...');


						if (myDropzone.files.length) {
							myDropzone.processQueue(); // upload files and submit the form
						} else {
							elegant_form_submit(); // just submit the form
						}
					}
					
				});

				this.on("successmultiple", function (file, response) {
					Notiflix.Loading.Remove();
					//reset dropzone
					$('#dropzone-previews').empty();
					console.log(response);
					if(response.status == 'success'){
						$('#elegant-form')[0].reset();
						Notiflix.Notify.Success('Sent Successfully!', {cssAnimationStyle:'zoom', cssAnimationDuration:500 , position: 'right-bottom'});
					}else{
						Notiflix.Report.Failure('Something Wrong!','<p style="text-align:center;">Please try again later.</p>', {cssAnimationStyle:'zoom', cssAnimationDuration:500 });
					}
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
					console.log(errorMessage);
				})
			}
		});
	}else{
		$('#elegant-form').on('submit',function(e){
			e.preventDefault();
			elegant_form_submit();
		});
	}

	function elegant_form_submit(){

		var url = $('#elegant-form').attr('data-url');
		var allcheck = [];
		$('#elegant-form .input-text-checkbox').each(function() {
			allcheck.push($(this).attr('name'));
		});
		Notiflix.Loading.Hourglass('Sending...');
		var formData = $('#elegant-form').serializeArray().reduce(function(obj, item) {
			obj[item.name] = item.value;
			return obj;
		}, {});


		$.ajax({
			type: "POST",
			url: url,
			data:formData,
			success: function(response){
				//if request if made successfully then the response represent the data
				Notiflix.Loading.Remove();
				if(response.status == 'success'){
					$('#elegant-form')[0].reset();
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

	}

	// Captcha Refresh Click
	$('.refresh').on('click', function(){

		$('#textCaptcha').addClass('active');
        $('#textCaptcha').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
        	$(this).removeClass('active');
        });

		createCaptcha();
	});

	$(".re").click(function(){
		$('#mathCaptcha').addClass('active');
        $('#mathCaptcha').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
        	$(this).removeClass('active');
        });
		randomnum();
	});

	



 });
