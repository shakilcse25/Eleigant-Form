<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://codesforprogress.com
 * @since      1.0.0
 *
 * @package    Elegant_Form
 * @subpackage Elegant_Form/admin/partials
 */
?>
<div class="card my-card">
    <?php settings_errors(); ?>
    <div class="card-header">
        <div class="card-header-inner">
            <span></span>
            <button class="btn btn-info add" type="button" id="add" >Add a Field</button>
        </div>
    </div>
    <div class="card-body">
        <form class="row g-3 needs-validation" id="create-form" method="post" action="options.php" novalidate>
            <?php 
                settings_fields( 'elegant_form_settings' );
                do_settings_sections( 'elegant_form' );
                echo '<div class="form_group"></div>';
                submit_button();
            ?>
        </form>
    </div>
</div>

<script>
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
	var forms = document.querySelectorAll('.needs-validation');

	// Loop over them and prevent submission
	Array.prototype.slice.call(forms)
	  .forEach(function (form) {
		form.addEventListener('submit', function (event) {
		  if (!form.checkValidity()) {
			event.preventDefault()
			event.stopPropagation()
		  }
  
		  form.classList.add('was-validated')
		}, false)
	})
</script>