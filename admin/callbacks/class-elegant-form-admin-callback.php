<?php

/**
 * The admin-specific callbacks of the plugin.
 *
 * @link       https://codesforprogress.com
 * @since      1.0.0
 *
 * @package    Elegant_Form
 * @subpackage Elegant_Form/admin/callbacks
 */

class Elegant_Form_Admin_Callback{

    public function pageRender(){
		$file = ELEGANT_FORM_DIR_PATH.'admin/partials/'.((isset($_GET['page'])) ? $_GET['page'].'.php' : 'no-file.php');
        ob_start();
		if(file_exists($file)){
			include_once($file);
		}
		$template = ob_get_contents();
		ob_end_clean();
		echo $template;
    }

	public function efSectionManager(){
    }

    public function efSanitize($input){
        $output = get_option( 'elegant_form' );
        $combine_array = array_combine($input['field_name'],$input['field_type']);
        $output = [
            [$input['form_name'] => $combine_array]
        ];

        return $output;
    }

    public function textField($args){
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
		$isArray = false;
		if($name == 'field_name' || $name == 'field_type'){
			$isArray = true;
		}

        echo '<input type="text" class="regular-text" id="'.$name.'" name="'.$option_name.'['.$name.']'. (($isArray) ? '[]' : '') .'" value="'.$value.'" placeholder="'. $args['placeholder'] .'" required>';
    }

    public function checkboxField($args){
		die();
        $name = $args['label_for'];
        $class = $args['class'];
        $option_name = $args['option_name'];
        $checkbox = get_option($option_name);
        $checked = false;

        if(isset($_POST['edit_post'])){
            $value = (isset($checkbox[$_POST['edit_post']][$name])) ? $checkbox[$_POST['edit_post']][$name] : false;
            $checked = ($value) ? true : false;
        }

        echo '<input type="checkbox" name="'.$option_name.'['.$name.']" value="1" class="'.$class.'" '. (($checked) ? 'checked' : '') .' />';
    }


    public function dropDownField($args){
        $name = $args['label_for'];
        $class = $args['class'];
        $option_name = $args['option_name'];
        $checkbox = get_option($option_name);
        $checked = false;

        // if(isset($_POST['edit_post'])){
        //     $value = (isset($checkbox[$_POST['edit_post']][$name])) ? $checkbox[$_POST['edit_post']][$name] : false;
        //     $checked = ($value) ? true : false;
        // }

        echo '<input type="checkbox" name="'.$option_name.'['.$name.']" value="1" class="'.$class.'" '. (($checked) ? 'checked' : '') .' />';
        echo '<select name="'.$option_name.'['.$name.']'. (($isArray) ? '[]' : '') .'" class="'.$class.'"><option value="input">Input Field</option><option value="checkbox">CheckBox</option><option value="text-area">Text Area</option><option value="radio">Radio</option></select>';
    }
	
}