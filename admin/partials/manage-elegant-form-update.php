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


    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $form = get_option( 'elegant_form' );

    $mainform = array();
    foreach ($form as $value) {
      if($value['form-id'] == $id){
        $mainform = $value;
      }
    }

    unset($mainform['form-id']);
    unset($mainform['bg']);
    unset($mainform['text_color']);

?>




<div class="card my-card">
    <?php settings_errors(); ?>
    <div class="card-body">
        <form class="g-3 needs-validation" id="create-form" method="post" action="options.php" novalidate>
            <?php 
                settings_fields( 'elegant_form_settings' );
                do_settings_sections( 'elegant_form' );
                $single_field = '';
                foreach ($mainform as $key => $value) {

                  $option = false;
                  $all_option = '';
                  $dynamic_option = '';

                  if(is_array($value)){
                    $option = true;
                    foreach ($value as $optionkey => $option_value) {
                      if (!is_int($optionkey)) {
                          continue;
                      }

                      $all_option .= '<li class="list-group-item option-list"><input type="text" class="form-control" name="elegant_form[options]['.$key.'][]" value="'. $option_value .'" readonly=""><button type="button" class="btn-close option-close" aria-label="Close"></button></li>';
                    }
                    $dynamic_option = '<div class="dynamic_option"><div class="dynamic_select"><ul class="list-group dynamic-list-option">'. $all_option .'</ul></div><div class="add_option"><input type="text" id="single_option" class="form-control"> <button class="btn btn-primary add_option_button" type="button">Add Option</button> </div></div>';

                  }

                  $single_field .= '<div class="bg-light inner-form-group border p-4 single_block"> <div class="row"><div class="col-md-6"><label class="form-label">Label Name</label><input type="text" class="form-control" id="field_name" name="elegant_form[field_name][]" value="'. $key .'" placeholder="Field Name" required=""></div> <div class="col-md-6"><label class="form-label">Field Type</label><select name="elegant_form[field_type][]" class="form-select field_type"><option value="input" '. (($value == 'input') ? 'selected' : '') .' >text-field</option><option value="checkbox" '. (($value == 'checkbox') ? 'selected' : '') .' >check-box</option><option value="text-area" '. (($value == 'text-area') ? 'selected' : '') .' >text-area</option><option value="dropdown" '. (is_array($value) && $value['type'] == 'dropdown' ? 'selected' : '') .' >dropdown</option><option value="file" '. (($value == 'file') ? 'selected' : '') .' >file</option><option value="text-captcha" '. (($value == 'text-captcha') ? 'selected' : '') .' >text-captcha</option><option value="math-captcha" '. (($value == 'math-captcha') ? 'selected' : '') .' >math-captcha</option></select>'. $dynamic_option .'</div></div><input data-id="2" type="button" class="btn btn-danger remove-input" value="-"></div>';

                  
                }
                echo '<div class="form_group" id="sortable" > '. $single_field .' </div>';
                echo '<input type="hidden" name="method" value="update" />';

                echo '<p class="addBtn"><button class="btn btn-info add" type="button" id="add" >Add a Field</button></p>';
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