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
        $id = (isset($_GET['id'])) ? $_GET['id'] : '';
        $page = (isset($_GET['page'])) ? $_GET['page'] : '';

        $file = '';
        if(!empty($page)){
            if(empty($id)){
                $file = ELEGANT_FORM_DIR_PATH.'admin/partials/'.$page.'.php';
            }else{
                $file = ELEGANT_FORM_DIR_PATH.'admin/partials/'.$page.'-id.php';
            }
        }
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
        $combine_array['form-id'] = md5(uniqid(rand(), true));
        $combine_array['bg'] = $input['bg'];
        $combine_array['text_color'] = $input['text_color'];
        $options = isset($input['options']) ? $input['options'] : array();

        foreach ($combine_array as $key => $value) {
            if($value == 'dropdown' && array_key_exists($key,$options)){
                $options[$key]['type'] = $value;
                $combine_array[$key] = $options[$key];
            }
        }
        $output[$input['form_name']] =  $combine_array;
        return $output;
    }

    public function textField($args){
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $value = '';
        $type = 'text';
		$isArray = false;
		if($name == 'field_name' || $name == 'field_type'){
			$isArray = true;
		}
        $arr = ($isArray) ? '[]' : '';
        
        switch ($name) {
            case 'bg':
                $value = '#EBECF0';
                $type = 'color';
                break;
            case 'text_color':
                $value = '#000000';
                $type = 'color';
                break;
        }

        echo '<input type="'.$type.'" class="form-control input-field" id="'.$name.'" name="'.$option_name.'['.$name.']'.$arr.'" value="'.$value.'" placeholder="'. $args['placeholder'] .'" required>';
    }

    // public function checkboxField($args){
	// 	die();
    //     $name = $args['label_for'];
    //     $class = $args['class'];
    //     $option_name = $args['option_name'];
    //     $checkbox = get_option($option_name);
    //     $checked = false;

    //     if(isset($_POST['edit_post'])){
    //         $value = (isset($checkbox[$_POST['edit_post']][$name])) ? $checkbox[$_POST['edit_post']][$name] : false;
    //         $checked = ($value) ? true : false;
    //     }

    //     echo '<input type="checkbox" name="'.$option_name.'['.$name.']" value="1" class="'.$class.'" '. (($checked) ? 'checked' : '') .' />';
    // }


    public function dropDownField($args){
        $name = $args['label_for'];
        $class = $args['class'];
        $option_name = $args['option_name'];
        $checkbox = get_option($option_name);
        $checked = false;
        $isArray = false;
		if($name == 'field_name' || $name == 'field_type'){
			$isArray = true;
		}
        $arr = ($isArray) ? '[[]]' : '';

        // if(isset($_POST['edit_post'])){
        //     $value = (isset($checkbox[$_POST['edit_post']][$name])) ? $checkbox[$_POST['edit_post']][$name] : false;
        //     $checked = ($value) ? true : false;
        // }
        echo '<select name="'.$option_name.'['.$name.']'.$arr.'" class="form-select field_type dropdown-field '.$class.'"><option value="input">Input Field</option><option value="checkbox">CheckBox</option><option value="text-area">Text Area</option><option value="dropdown">DropDown</option></select>';
    }
	
}